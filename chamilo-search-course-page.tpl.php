<div class="chamilo-courses">
  <ul>
    <?php foreach ($output as $course): ?>
    <li class="chrow">
      <h4><?php print $course->name; ?></h4>
      <p><?php print $course->extra[3]->value; ?></p>
      <?php if (!empty($course->extra[2]->value)):?>
      <div class="session-mode f-left">
        <em>Modalidad</em>
        <p><?php print $course->extra[2]->value; ?></p>  
      </div>
      <?php endif; ?>
      <?php if (!empty($course->date_start)):?>
      <div class="session-date-start f-left">
        <em>Fecha de inicio</em>
        <p><?php print $course->date_start; ?></p>  
      </div>
      <?php endif; ?>
      <?php if (!empty($course->date_end)):?>
      <div class="session-date-end f-left">
        <em>Fecha de fin</em>
        <p><?php print $course->date_end; ?></p>
      </div>
      <?php endif; ?>
      <?php if (!empty($course->duration)):?>
      <div class="session-duration f-left">
        <em>Duración</em>
        <p><?php print $course->duration; ?></p>
      </div>
      <?php endif; ?>
      <?php if (!empty($course->extra[0]->value)):?>
      <div class="session-vacancies f-left">
        <em>Cupos</em>
        <p><?php print $course->extra[0]->value; ?></p>
      </div>
      <?php endif; ?>
      <?php if (!empty($course->extra[1]->value)):?>
      <div class="session-schedule f-left">
        <em>Horario</em>
        <p><?php print $course->extra[1]->value; ?></p>
      </div>
      <?php endif; ?>
      <div class="ajax-container">
        <div id="ajax-link-<?php print $course->id; ?>" class="ajax-link">
          <?php print $course->link; ?>
        </div>
        <div id="ajax-detail-<?php print $course->id; ?>" class="session-detail clearfix"></div>  
      </div>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
