<?php 


function inputField($id, $name, $type='T', $value, $choice, $is_edit){
    switch ($type) {
        case 'T':
            return inputBox($id, $name, $value, $is_edit);
            break;
        case 'P':
            return inputPassword($id, $name, $value, $is_edit);
            break;
        case 'S':
            return inputCombo($id, $name, $choice, $value, $is_edit);
            break;
        default:
            break;
    }
}

function inputBox($id, $name, $value, $is_edit=true){
    $html = "<input type='text' ".($id ? "id='$id'" : "")." ".($name ? "name='$name'" : "")." ".($value ? "value='$value'" : "")."/>";
    return $is_edit===true ? $html : $value;
}

function inputPassword($id, $name, $value, $is_edit=true){
    $html = "<input type='password' ".($id ? "id='$id'" : "")." ".($name ? "name='$name'" : "")." ".($value ? "value='$value'" : "")."/>";
    return $is_edit===true ? $html : "&#x2022;&#x2022;&#x2022;" ;
}

function inputCombo($id, $name, $choice=array(), $value, $is_edit=true){
    $html = "<select ".($id ? "id='$id'":"")." ".($name ? "name='$name'" : "").">";
    foreach($choice as $k => $v){
        $html .= "<option value='$k' ".($value==$k ? "selected" : "")." >" . $v . "</option>";
    }
    $html .= "</select>";
    return $is_edit===true ? $html : $choice[$value];
}

function actionButton($choice = array(), $id){
    $html = "";
    foreach($choice as $c){
        switch ($c) {
            case 'Edit':
                $html .= "<input onClick='actEdit(".$id.")' value='edit' type='button'> ";
                break;
            case 'Delete':
                $html .= "<input onClick='actDelete(".$id.")' value='delete' type='button'> ";
                break;
            case 'Save':
                $html .= "<input onClick='actSave($id)' value='save' type='button'> ";
                break;
            default:
                break;
        }
    }

    return $html;
}

function setRecord($post, $columns){        
    $record = array();
    foreach($post as $k => $v){
        if(in_array($k, $columns)){
            $record[$k]=$v;
        }
    }

    return $record;
}