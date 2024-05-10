<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>

<article class="vehicle" id="vehicle">
    <h1>Welcome to PHP Motors!</h1>
    <div class="vehicle-delorean">
        <h2 class="vehicle-h2">
            DMC Delorean
        </h2>
        <div class="vehicle-div">
            <p class="vehicle-p">
                3 Cup holders <br>
                Superman doors <br>
                Fuzzy dice!
            </p>
            <div class="vehicle-img">
                <img src="/phpmotors/images/vehicles/delorean.jpg" alt="gray Delorean car">
            </div>
            <div class="button">
                <img src="/phpmotors/images/site/own_today.png" alt="Own Today">
                <!--<button class="buy-button">
                    Own Today
                </button> -->
            </div>
        </div>
    </div>
    <div class="rev-up">
        <div class="row">
            <div class="column">
                <div class="vehicle-reviews" id="vehicle-reviews">
                    <h2 class="rev">DMC Delorean Reviews</h2>
                    <div class="reviews">
                        <ul>
                            <li>
                                "So fast it's almost like traveling in time." (4/5)
                            </li>
                            <li>
                                "Coolest ride on the road." (4/5)
                            </li>
                            <li>
                                "I'm feeling Marty McFly!" (5/5)
                            </li>
                            <li>
                                "The most futeristic ride of our day." (4.5/5)
                            </li>
                            <li>
                                "80's livin' and I love it!" (5/5)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="vehicle-upgrades" id="vehicle-upgrades">
                    <h2 class="up">Dolorean upgrades</h2>
                    <div class="upgrades">
                        <div class="upgrade-1">
                            <img src="/phpmotors/images/upgrades/flux-cap.png" alt="flux capacitor">
                            <a href="">Flux Capacitor</a>
                        </div>
                        <div class="upgrade-2">
                            <img src="/phpmotors/images/upgrades/flame.jpg" alt="flame">
                            <a href="">Flame Decals</a>
                        </div>
                        <div class="upgrade-3">
                            <img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="bumper sticker">
                            <a href="">Bumper Stickers</a>
                        </div>
                        <div class="upgrade-4">
                            <img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="hub cap">
                            <a href="">Hub Caps</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>