let process_response = function (json) {
    
    console.log('process_response', json);
    
    //---
    
    <?php echo $form_active["process_response"] ?? "" ?>
    
    //---
    
}

let myform = {
    'title': '<?php echo $form_active["title"] ?? "" ?>',
    process_response,
    inputs: <?php echo json_encode($form_active["inputs"] ?? [], JSON_PRETTY_PRINT) ?>,    
}

export default myform;
    
    