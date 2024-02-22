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
foreach ($data as $item) {
    $selected[] = $item->group_id;
    if (!isset($grouped_by_step[$item->step_no])) {
        $grouped_by_step[$item->step_no] = [];
    }
    $grouped_by_step[$item->step_no][] = $item->group_id;
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
            // If any existing box contains items or no boxes exist yet, create a new box with an incremented level number
            var newLevel = boxes.length;
            var newBox = document.createElement("div");
            newBox.className = "box";
            newBox.id = newLevel;
            newBox.innerHTML = "<h6 class='text-center'>level " + newLevel + "</h6>";

            // Append the new box to the hierarchy card
            hierarchyCard.insertBefore(newBox, hierarchyCard.querySelector(".add-btn"));

            // Attach drop event listeners to the new box
            newBox.addEventListener("drop", drop);
            newBox.addEventListener("dragover", allowDrop);

            // Create the arrow div
            var arrowDiv = document.createElement("div");
            arrowDiv.className = "arrow text-center mt-2 mb-2";
            arrowDiv.innerHTML = '<i class="fa-solid fa-arrow-down-long text-primary"></i>';

            // Append the arrow div above the new box
            hierarchyCard.insertBefore(arrowDiv, newBox);

            // Scroll to the newly created box
            newBox.scrollIntoView({
                behavior: "smooth",
                block: "end"
            });
        } else {
            // If no existing box contains items, show an alert
            var alertDiv = document.createElement("div");
            alertDiv.className = "alert alert-danger";
            alertDiv.setAttribute("role", "alert");
            alertDiv.textContent = "Please add items to the last level before adding a new level.";

            // Append the alert to the card body
            hierarchyCard.appendChild(alertDiv);

            // Scroll to the alert
            alertDiv.scrollIntoView({
                behavior: "smooth",
                block: "end"
            });
        }
    });
</script>