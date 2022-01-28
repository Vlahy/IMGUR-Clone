<?php

include HEADER;
include NAVIGATION;

?>

    <div class="container">
        <div class="row mt-5 justify-content-center align-items-center">
            <div class="col-4">
                <div class="card">
                    <form class="card-body" method="post" action="<?php echo SUBSCRIBE_FORM_SUBMIT ?>">
                        <h5 class="card-header mb-2">Choose Subscription Plan</h5>

                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="subscription_type" id="one_month" value="one_month" checked>
                            <label class="form-check-label" for="one_month">
                                One Month
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="subscription_type" id="six_months" value="six_months">
                            <label class="form-check-label" for="six_months">
                                Six Months
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="subscription_type" id="twelve_months" value="twelve_months">
                            <label class="form-check-label" for="twelve_months">
                                Twelve Months
                            </label>
                        </div>

                        <button id="submit" type="submit" value="submit" class="btn btn-outline-primary mt-2">Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
include FOOTER;