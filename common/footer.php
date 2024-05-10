</main>
<footer>
    <p>&copy; PHP Motors. All rights reserved. <br>
        All images used are believed to be in "Fair Use". Please notify the author if any are not and they will
        be
        removed. <br>
        Last Updated: <?php echo date('j F, Y', getlastmod()); ?>
    </p>
</footer>
</div>
<script src="../js/inventory.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); unset($_SESSION['message-pass']); unset($_SESSION['message-update']); ?>