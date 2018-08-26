/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function array_to_object(array) {
    var set_obj = {};
    for (var key in array) {
        set_obj[key] = array[key];
    }
    return set_obj;
}