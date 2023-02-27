<?php

function weekDayConverterToPortuguese ($day) {
    
    switch ($day) {
        case 'Sunday':
            return 'Domingo';
            break;
        case 'Monday':
            return 'Segunda';
            break;
        case 'Tuesday':
            return 'Terça';
            break;
        case 'Wednesday':
            return 'Quarta';
            break;            
        case 'Thursday':
            return 'Quinta';
            break;
        case 'Friday':
            return 'Sexta';
            break;
        case 'Saturday':
            return 'Sábado';
            break;                                    
    }
}

?>