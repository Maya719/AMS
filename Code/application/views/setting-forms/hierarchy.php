<?php
function compareByStepNo($a, $b)
{
    if ($a->step_no == $b->step_no) {
        return 0;
    }
    return ($a->step_no < $b->step_no) ? -1 : 1;
}
usort($data, 'compareByStepNo');
$selected = [];
$grouped_by_step = [];
$grouped_by_step_app_rec = [];
foreach ($data as $item) {
    $selected[] = $item->group_id;
    if (!isset($grouped_by_step[$item->step_no])) {
        $grouped_by_step[$item->step_no] = [];
        $grouped_by_step_app_rec[$item->step_no] = '';
    }
    $grouped_by_step[$item->step_no][] = $item->group_id;
    $grouped_by_step_app_rec[$item->step_no] = $item->recomender_approver;
}
?>
<!-- Nestable -->
<div class="row g-1">
    <div class="col-lg-3 mb-0">
        <div class="card">
            <div class="card-header">
                <h5>Role</h5>
            </div>
            <div class="card-body">
                <!-- Roles to drag -->
                <div class="box" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <ul class="draggable-list">
                        <?php
                        foreach ($groups as $group) {
                            if (!in_array($group->id, $selected) && $group->description != 'Employee' && $group->description != 'Clients') {
                        ?>
                                <li class="dd-item" data-id="<?= $group->id ?>" data-step="0" draggable="true" ondragstart="drag(event)">
                                    <div class="dd-handle"><?= $group->description ?></div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-0">
        <div class="card">
            <div class="card-header">
                <h5>Hierarchy</h5>
            </div>
            <div class="card-body mb-5" id="hierarchyCard">
                <!-- Drop zone -->
                <div class="box" id="level0">
                    <h6 class="text-center">Base / Leave Creater</h6>
                    <?php
                    foreach ($groups as $group) {
                        if (!in_array($group->id, $selected) && $group->description == 'Employee') {
                    ?>
                            <li class="dd-item" data-id="<?= $group->id ?>" data-step="0" draggable="false">
                                <div class="dd-handle"><?= $group->description ?></div>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </div>

                <?php foreach ($grouped_by_step as $step_no => $group_ids) : ?>
                    <div class="arrow text-center mt-2 mb-2">
                        <i class="fa-solid fa-arrow-down-long text-primary"></i>
                    </div>
                    <div class="box" id="level<?= $step_no ?>" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <h6 class="text-center">level <?= $step_no ?></h6>
                        <?php foreach ($group_ids as $group_id) : ?>
                            <?php foreach ($groups as $group) : ?>
                                <?php if ($group_id == $group->id) : ?>
                                    <li class="dd-item" data-id="<?= $group->id ?>" data-step="<?= $step_no ?>" draggable="true" ondragstart="drag(event)">
                                        <div class="dd-handle"><?= $group->description ?></div>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </div>
                <?php endforeach ?>
                <div class="add-btn d-flex justify-content-center">
                    <button type="button" class="btn tp-btn-light btn-primary mt-2" id="addBoxBtn"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-0">
        <div class="card">
            <div class="card-header">
                <h5>Approver/Recommender</h5>
            </div>
            <div class="card-body">
                <!-- Inputs -->
                <div class="box2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" checked>
                        <label class="form-check-label">
                            Creater
                        </label>
                    </div>
                </div>
                <?php foreach ($grouped_by_step_app_rec as $step_no => $group_ids) : ?>
                    <div class="arrow text-center mt-2 mb-2">
                        <i class="fa-solid fa-arrow-down-long text-primary"></i>
                    </div>
                    <div class="box2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="level<?= $step_no ?>" value="approver" <?= ($group_ids === 'approver') ? 'checked' : '' ?>>
                            <label class="form-check-label">
                                Approver
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="level<?= $step_no ?>" value="recommender" <?= ($group_ids === 'recommender') ? 'checked' : '' ?>>
                            <label class="form-check-label">
                                Recommender
                            </label>
                        </div>
                    </div>
                <?php endforeach ?>
                <div class="" id="box2Div"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-0">
        <div class="card">
            <div class="card-body">
                <div class="message"></div>
                <button type="button" id="saveBtn" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to handle the click event on the add button
        document.getElementById("addBoxBtn").addEventListener("click", function() {
            // Get the hierarchy card
            var hierarchyCard = document.getElementById("hierarchyCard");

            // Get all existing boxes
            var boxes = hierarchyCard.querySelectorAll(".box");
            var canAddLevel = true;

            // Check if any existing box contains items
            for (var i = 0; i < boxes.length; i++) {
                var itemsInBox = boxes[i].querySelectorAll(".dd-item");
                if (itemsInBox.length === 0) {
                    canAddLevel = false;
                    break;
                }
            }

            if (canAddLevel || boxes.length === 0) {
                var newLevel = boxes.length;
                var newBox = document.createElement("div");
                newBox.className = "box";
                newBox.id = newLevel;
                newBox.innerHTML = "<h6 class='text-center'>level " + newLevel + "</h6>";

                hierarchyCard.insertBefore(newBox, hierarchyCard.querySelector(".add-btn"));

                newBox.addEventListener("drop", drop);
                newBox.addEventListener("dragover", allowDrop);

                var arrowDiv = document.createElement("div");
                arrowDiv.className = "arrow text-center mt-2 mb-2";
                arrowDiv.innerHTML = '<i class="fa-solid fa-arrow-down-long text-primary"></i>';

                hierarchyCard.insertBefore(arrowDiv, newBox);

                newBox.scrollIntoView({
                    behavior: "smooth",
                    block: "end"
                });
                var box2Div = document.getElementById("box2Div");
                box2Div.insertAdjacentHTML('beforeend', `
                    <div class="arrow text-center mt-2 mb-2">
                        <i class="fa-solid fa-arrow-down-long text-primary"></i>
                    </div>
                    <div class="box2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="level` + newLevel + `" value="approver" checked>
                            <label class="form-check-label">
                                Approver
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="level` + newLevel + `" value="recommender">
                            <label class="form-check-label">
                                Recommender
                            </label>
                        </div>
                    </div>
                `);
            } else {
                var alertDiv = document.createElement("div");
                alertDiv.className = "alert alert-danger";
                alertDiv.setAttribute("role", "alert");
                alertDiv.textContent = "Please add items to the last level before adding a new level.";
                hierarchyCard.appendChild(alertDiv);
                alertDiv.scrollIntoView({
                    behavior: "smooth",
                    block: "end"
                });
            }
        });
    });
    window.addEventListener('DOMContentLoaded', function() {
        var box2Elements = document.querySelectorAll('.box2');
        box2Elements.forEach(function(box2Element, index) {
            var boxElement = document.getElementById('level' + index);
            var boxHeight = boxElement.offsetHeight;
            box2Element.style.height = boxHeight + 'px';
        });
    });
</script>