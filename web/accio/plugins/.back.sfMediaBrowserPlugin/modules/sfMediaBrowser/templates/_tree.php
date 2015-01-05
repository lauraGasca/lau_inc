<h3>Directorios:</h3>
<div style="">
<div id="demo1" class="demo">
  <ul class="nested_set_list">
        <?php $prevLevel = 0;$actual='"phtml_0"';?>
        <?php $encontro = false;$ultimo=1; ?>
        <?php for ($key = 0; $key < count($record); $key++): ?>
            <?php if($prevLevel > 0 && $record[$key]['nivel'] == $prevLevel)  echo '</li>';
           if($record[$key]['nivel'] > $prevLevel){
                //Voy guardando los id de las actividades padres, para abrirlas en jstree
               if(!$encontro && $ultimo!=0)
                    $actual .= ', "phtml_'.$ultimo.'"';
               echo '<ul>';
            }
            elseif ($record[$key]['nivel'] < $prevLevel) echo str_repeat('</ul></li>', $prevLevel - $record[$key]['nivel']); ?>
            <li id ="phtml_<?php echo $record[$key]['id'] ?>">
                <?php if($dir_actual==$record[$key]['path']):?>
                    <a href="<?php echo url_for('@'.$ruta.'?dir='.$record[$key]['path'])?>" style="font-weight: bold; color: #b81900 "><ins>&nbsp;</ins><?php echo $record[$key]['nombre'];?></a>                  
                    <?php $encontro=true;
                    $actual .= ', "phtml_'.$record[$key]['id'].'"';
                    ?>
                <?php else:?>
                    <a href="<?php echo url_for('@'.$ruta.'?dir='.$record[$key]['path'])?>"><ins>&nbsp;</ins><?php echo $record[$key]['nombre'];?></a>
                <?php endif;?>
            <?php $prevLevel = $record[$key]['nivel'];
            $ultimo =  $record[$key]['id'];
        endfor; ?>
   </ul>
</div>
</div>
<script type="text/javascript" class="source">
$(function () {
        $("#demo1").jstree({
                themes : {
			"theme" : "classic"
		},
                core : { "initially_open" : [<?php echo $actual; ?>] },
		plugins : [ "themes", "html_data" , "types" ]
	});    
});

//Al momento de enviar analizo todos los objetos que pertenescan a la clase .jstree-checked y .jstree-undetermined
//Estas clases determinan si una actividad (hijo, padre) fue seleccionada o no
//Les quito la cadena "phtml_" a los id's y los guardo en un arreglo, el cual se imprime en el campo oculto #categorias_sel
$('form').submit(function(){
        var checked_ids = [];
        var id='';
        $(".jstree-checked").each(function () {
          id =this.id;
          checked_ids.push(id.replace("phtml_",""));
        });

        $(".jstree-undetermined").each(function () {
          id =this.id;
          checked_ids.push(id.replace("phtml_",""));
        });
        $('#categorias_sel').val(checked_ids.join(","));
});
</script>
