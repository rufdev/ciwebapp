<?php include 'header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include 'menu.php'; ?>

    <div class="content-wrapper">
      <?= $this->renderSection('content'); ?>
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>

  </div>
  <!-- ./wrapper -->
  <?php include 'scripts.php'; ?>

  <?= $this->renderSection('pagescripts'); ?>
</body>

</html>