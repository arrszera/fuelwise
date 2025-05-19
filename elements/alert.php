<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
    if (isset($_SESSION['alert']) && $_SESSION['alert'] != 0){ ?>
        <script>
            Swal.fire({
                title:"<?= htmlspecialchars($_SESSION['alert']['title']) ?>",
                text:"<?= htmlspecialchars($_SESSION['alert']['text']) ?>",
                icon:"<?= htmlspecialchars($_SESSION['alert']['icon']) ?>",
                confirmButtonColor: "#2563eb",
                <?php if (isset($_SESSION['alert']['iconColor'])){ ?>
                    iconColor:"<?= htmlspecialchars($_SESSION['alert']['icon']) ?>",
                <?php } ?> 
            })
        </script>
<?php
        $_SESSION['alert'] = 0;
    }
?>