<div class="ajax-container-close">
  <a href="<?php print base_path(); ?>close-course-detail-ajax/nojs/<?php print $course_id; ?>" class="use-ajax">Cerrar detalle</a>
</div>
<div class="cb-inner-container-left"> 
  <ul> 
    <li class="clearfix">
      <strong>Id:</strong>
      <p>
        <?php print $output->code; ?>
      </p>
    </li>
    <li class="clearfix">
      <strong>Costo:</strong>
      <p>
        <?php print $output->cost; ?>
      </p>
    </li>
    <li class="clearfix">
      <strong>Lugar:</strong>
      <p>
        <?php print $output->place; ?>
      </p>
    </li>
    <li class="clearfix">
      <strong>Sesión permite visitantes:</strong>
      <p>
        <?php 
          if (!empty($output->allow_visitors)) {
            print 'Si';
          } 
          else {
            print 'No';
          }
        ?>
      </p>
    </li>
    <li class="clearfix">
      <strong>Cantidad de horas lectivas:</strong>
      <p>
        <?php print $output->duration; ?>
      </p>
    </li>
    <?php if(!empty($output->banner)): ?>
    <li class="clearfix">
      <img src="<?php print $output->banner; ?>" />
    </li>
    <?php endif; ?>
  </ul> 
</div>
<div class="cb-inner-container-middle">
  <p><?php print $output->description; ?></p>
  <?php if(!empty($output->brochure)): ?>
  <a href="<?php print $output->brochure; ?>" class="download-link" donwload>Descargar brochure</a>
  <?php endif; ?>
</div>
<div class="cb-inner-container-right">
  <?php if ($output->status == -1): ?>
    <a href="<?php print $output->action_url; ?>" class="session-register">Inscribirse</a>
  <?php endif; ?>

  <?php if ($output->status == 10): ?>
    <a href="<?php print $output->action_url; ?>" class="session-virtual-classroom">Ir aula virtual</a>
  <?php endif; ?>

  <?php if ($output->status == 1): ?>
    <div class="session-message status-three">
      <p class="session-message">
        <?php print $output->message; ?>
      </p>
    </div>
  <?php endif; ?>

  <?php if ($output->status == 2): ?>
    <div class="session-message status-two">
      <p class="session-message">
        <?php print $output->message; ?>
      </p>
    </div>
  <?php endif; ?>

  <?php if ($output->status == 3): ?>
    <div class="session-message status-three">
      <p class="session-message">
        <?php print $output->message; ?>
      </p>
    </div>
  <?php endif; ?>

  <?php if ($output->status == 0): ?>
    <div class="session-message status-one">
      <p class="session-message">
        <?php print $output->message; ?>
      </p>
    </div>
  <?php endif; ?>
</div>

