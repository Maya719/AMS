<main>
    <table class="table table-bordered resp-pricing-table">
        <thead>
            <tr>
                <th scope="col">Features</th>
                <th scope="col">Basic</th>
                <th scope="col">Standard</th>
                <th scope="col">Premium</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td data-label="">Storage (GB)</td>

                <?php
                foreach ($plans as $key => $plan) {
                ?>
                    <td data-label=<?= $plan['title'] ?>> <?= ($plan['storage'] == -1) ?  'unlimited' : $plan['storage'] ?> </td>
                <?php
                }
                ?>

                <!-- <td data-label="Basic">2</td>
                    <td data-label="Standard">25</td>
                    <td data-label="Premium">Unlimited</td> -->
            </tr>
            <tr>
                <td data-label="">Projects</td>

                <?php
                foreach ($plans as $key => $plan) {
                ?>
                    <td data-label=<?= $plan['title'] ?>> <?= ($plan['projects'] == -1) ?  'unlimited' : $plan['projects'] ?> </td>
                <?php
                }
                ?>
                <!-- <td data-label="Basic">3</td>
                    <td data-label="Standard">10</td>
                    <td data-label="Premium">Unlimited</td> -->
            </tr>
            <tr>
                <td data-label="">Tasks</td>

                <?php
                foreach ($plans as $key => $plan) {
                ?>
                    <td data-label=<?= $plan['title'] ?>> <?= ($plan['tasks'] == -1) ?  'unlimited' : $plan['tasks'] ?> </td>
                <?php
                }
                ?>

                <!-- <td data-label="Basic">50</td>
                    <td data-label="Standard">100</td>
                    <td data-label="Premium">Unlimited</td> -->
            </tr>
            <tr>
                <td data-label="">Employees <br><strong style="font-size: 14px;">Employee addition: $3</strong></td>

                <?php
                foreach ($plans as $key => $plan) {
                ?>
                    <td data-label=<?= $plan['title'] ?>> <?= ($plan['users'] == -1) ?  'unlimited' : $plan['users'] ?> </td>
                <?php
                }
                ?>


                <!-- <td data-label="Basic">8</td>
                <td data-label="Standard">20</td>
                <td data-label="Premium">30</td> -->
            </tr>
            <tr>
                <td data-label="">Pricing</td>

                <?php
                foreach ($plans as $key => $plan) {
                ?>
                    <td data-label=<?= $plan['title'] ?>><span>$</span> <?= $plan['price'] ?> <br>
                        <span><?= ($plan['billing_type'] == 'seven_days_trial_plan') ? '7 days plan' : $plan['billing_type'] ?></span>
                    </td>
                <?php
                }
                ?>

                <!-- <td data-label="Basic"><span>$</span> 0 <br>
                    <span> 7 days trial</span>
                </td>

                <td data-label="Standard">
                    <span>$</span> 15 <br>
                    <span> per month </span>
                </td>

                <td data-label="Premium">
                    <span>$</span> 30 <br>
                    <span> one time</span>
                </td> -->
            </tr>
            <tr>
                <td data-label="Actions">Actions</td>

                <?php
                foreach ($plans as $key => $plan) {
                ?>
                    <td data-label=<?= $plan['title'] ?>>
                        <a href="<?= base_url('auth/register') ?>" class="tp-btn">Get Started Now <i class="fa-regular fa-arrow-right-long"></i></a>
                    </td>
                <?php
                }
                ?>


                <!-- <td data-label="Basic">
                    <a href="<?= base_url('auth/register') ?>" class="tp-btn">Get Started Now <i class="fa-regular fa-arrow-right-long"></i></a>
                </td>
                <td data-label="Standard">
                    <a href="<?= base_url('auth/register') ?>" class="tp-btn">Get Started Now <i class="fa-regular fa-arrow-right-long"></i></a>
                </td>
                <td data-label="Premium">
                    <a href="<?= base_url('auth/register') ?>" class="tp-btn">Get Started Now <i class="fa-regular fa-arrow-right-long"></i></a>
                </td> -->
                
            </tr>
        </tbody>
    </table>

</main>