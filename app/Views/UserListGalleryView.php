<?php
include HEADER;
include NAVIGATION;
if (isset($data) && $data != null) {
    $user_info = $data['user_info'];
    $subscription_info = $data['subscription_info'];
    $galleries = $data['galleries'];
    $subscription_history = $data['subscription_history'];
    ?>


    <div class="container mt-5">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingUserInfo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseUserInfo" aria-expanded="false" aria-controls="collapseUserInfo">
                        User Info:
                    </button>
                </h2>
                <div id="collapseUserInfo" class="accordion-collapse collapse" aria-labelledby="headingUserInfo"
                     data-bs-parent="#accordionUserInfo">
                    <div class="accordion-body">
                        <h4 class="mt-3 lead display-8">Username: <?= $user_info[0]['username'] ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ((isset($_SESSION['user_id']) && $_SESSION['user_id'] === $user_info[0]['id']) || (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')) : ?>

        <div class="container mt-5">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSubscription">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSubscription" aria-expanded="false"
                                aria-controls="collapseOne">
                            Subscription Info:
                        </button>
                    </h2>
                    <div id="collapseSubscription" class="accordion-collapse collapse"
                         aria-labelledby="headingSubscription" data-bs-parent="#accordionSubscription">
                        <div class="accordion-body">
                            <h4 class="mt-3 lead display-8">Subscription
                                Type: <?= $subscription_info[0]['subscription_type'] ?></h4>
                            <h4 class="mt-3 lead display-8">Subscription is active
                                until: <?= $subscription_info[0]['end_date'] ?></h4>
                            <?php if ($_SESSION['user_id'] === $user_info[0]['id'] && $subscription_info[0]['subscription_type'] == 'free') : ?>
                                <form name="startSubscription" method="get" action="<?php echo SUBSCRIBE_PAGE_URL ?>">
                                    <button type="submit" class="btn btn-outline-success mt-2">Subscribe</button>
                                </form>
                            <?php endif; ?>
                            <?php if (in_array($subscription_info[0]['subscription_type'], ['one_month', 'six_months', 'twelve_months'])) : ?>
                                <form class="mt-2" name="cancelSubscription" method="post"
                                      action="<?php echo CANCEL_SUBSCRIPTION ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                    <input type="hidden" name="subscription_id"
                                           value="<?php echo $subscription_info[0]['id'] ?>">
                                    <button type="submit" class="btn btn-outline-danger mt-2">Cancel Subscription
                                    </button>
                                </form>

                                <div>
                                    <button class="btn btn-outline-success mt-2" data-bs-toggle="modal"
                                            data-bs-target="#changeSubscriptionModal">Change Subscription
                                    </button>
                                </div>

                                <!-- Modal for changing subscription-->
                                <div class="modal fade" id="changeSubscriptionModal" tabindex="-1"
                                     aria-labelledby="changeSubscriptionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="changeSubscriptionModalLabel">Edit
                                                    Gallery</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="card-body" method="post"
                                                      action="<?php echo CHANGE_SUBSCRIPTION_TYPE ?>">
                                                    <h5 class="card-header mb-2">Choose Subscription Plan</h5>

                                                    <input type="hidden" name="user_id"
                                                           value="<?php echo $_SESSION['user_id'] ?>">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="change_subscription_type" id="one_month" value="one_month"
                                                               checked>
                                                        <label class="form-check-label" for="one_month">
                                                            One Month
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="change_subscription_type" id="six_months"
                                                               value="six_months">
                                                        <label class="form-check-label" for="six_months">
                                                            Six Months
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="change_subscription_type" id="twelve_months"
                                                               value="twelve_months">
                                                        <label class="form-check-label" for="twelve_months">
                                                            Twelve Months
                                                        </label>
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button id="submit" type="submit" value="submit"
                                                        class="btn btn-primary">Save changes
                                                </button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && !empty($subscription_history)) : ?>

        <div class="container mt-5">
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSubscriptionHistory">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSubscriptionHistory" aria-expanded="false"
                                aria-controls="collapseSubscriptionHistory">
                            Subscription History:
                        </button>
                    </h2>
                    <div id="collapseSubscriptionHistory" class="accordion-collapse collapse"
                         aria-labelledby="headingSubscriptionHistory"
                         data-bs-parent="#accordionSubscriptionHistory">
                        <div class="accordion-body">
                            <?php foreach ($subscription_history as $history) : ?>
                                <hr>
                                <h4 class="mt-3 lead display-8">Subscription
                                    Type: <?= $history['subscription_type'] ?></h4>
                                <h4 class="mt-3 lead display-8">Start Date: <?= $history['start_date'] ?></h4>
                                <h4 class="mt-3 lead display-8">End Date: <?= $history['end_date'] ?></h4>
                                <h4 class="mt-3 lead display-8">
                                    Status: <?php if ($history['is_active'] == true) echo 'Active'; else echo 'Inactive' ?></h4>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php
    echo '<div class="container mt-5">';
    echo '<h1 class="mt-3 lead display-4">Gallery <small class="text-muted">List</small></h1>';

    echo '<div class="row">';
    $counter = 0;
    foreach ($galleries as $gallery) {
        echo '<div class="col-sm-6 gy-4"><div class="card"><div class="card-body">';

        echo '<h5 class="card-title">' . $gallery->name . '</h5>';
        echo '<p class="card-text">' . $gallery->description . '</p>';
        echo '<a class="btn btn-primary" href="http://localhost/users/gallery/' . $gallery->id . '">Open Gallery</a>';

        echo '</div></div></div>';

        $counter++;
    }
    echo '</div>';

    include PAGE_NAVIGATION;

    echo '</div></div>';
}

include FOOTER;
