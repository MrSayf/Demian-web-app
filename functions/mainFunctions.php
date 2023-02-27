<?php

// indice de massa corporal
function calculaIMC($peso, $altura)
{
    $alturaNova = $altura / 100;
    $val = $peso / ($alturaNova * $alturaNova);
    return number_format($val,2,".",".");
}

function tabelaIMC($imc)
{
    //echo $imc;
    switch ($imc) {
            //Underweigth
        case ($imc <= 18.49):
            return '1';
            break;
            //Normal
        case ($imc > 18.49 && $imc <= 24.99):
            return '2';
            break;
            //Overweigth
        case ($imc > 24.99):
            return '3';
            break;
    }
}


// how much calories should each one consume in a daily basis
function calorieIntake($frequenciaEsporte, $peso, $unidadeMedida)
{

    if ($unidadeMedida == 'Imperial') {
        // se for kg
        $mult = '2.2';
    } else {
        // se for libra
        $mult = '1';
    }

    switch ($frequenciaEsporte) {
            //Underweigth
        case "2 dias por semana":
            $calIntake = ($peso * $mult) * 13;
            return $calIntake;
            break;
            //Normal
        case "3 dias por semana":
            $calIntake = ($peso * $mult) * 15;
            return $calIntake;
            break;
            //OverweigthdispostoPerderPeso
        case "Mais de 3 dias por semana":
            
            $calIntake = ($peso * $mult) * 17;
            return $calIntake;
            break;
        case "Não faço esportes":
            $calIntake = ($peso * $mult) * 19;
            return $calIntake;
            break;
    }
}


// calculates weight loss, 5 kg/month
function calcWeightLossByMonth($peso, $pesoDesejado)
{
    $dataObjetivoFinal = ($peso - $pesoDesejado) / 5;

    if ($dataObjetivoFinal <= 1) {
        $monthPlus = 1;
    } else {
        $monthPlus = ceil($dataObjetivoFinal);
    }

    $var = " + {$monthPlus} months";
    $newDate = date('F', strtotime($var));
    $newDateYear = date( 'Y', strtotime($var));
    // retorna mes e ano e mes em portugues
    $a =  monthDayConverterToPortuguese($newDate).' de '.$newDateYear;
    return $a;
}

// calculates weight loss, 5 kg/month
function calcWeightLossByMonthOnlyMonth($peso, $pesoDesejado)
{
    $dataObjetivoFinal = ($peso - $pesoDesejado) / 5;

    if ($dataObjetivoFinal <= 1) {
        $monthPlus = 1;
    } else {
        $monthPlus = $dataObjetivoFinal;
    }

    $var = " + {$monthPlus} months";
    $newDate = date('F', strtotime($var));
    $newDateYear = date('Y', strtotime($var));
    // retorna mes e ano e mes em portugues
    $a =  monthDayConverterToPortuguese($newDate);
    return $a;
}

function monthDayConverterToPortuguese($month)
{
    switch ($month) {
        case 'January':
            return 'Janeiro';
            break;
        case 'February':
            return 'Fevereiro';
            break;
        case 'March':
            return 'Março';
            break;
        case 'April':
            return 'Abril';
            break;
        case 'May':
            return 'Maio';
            break;
        case 'June':
            return 'Junho';
            break;
        case 'July':
            return 'Julho';
            break;
        case 'August':
            return 'Agosto';
            break;
        case 'September':
            return 'Setembro';
            break;
        case 'October':
            return 'Outubro';
            break;
        case 'November':
            return 'Novembro';
            break;
        case 'December':
            return 'Dezembro';
            break;
    }
}



function monthTruncateConverterToPortuguese($month)
{
    switch ($month) {
        case 'Jan':
            return 'Jan';
            break;
        case 'Feb':
            return 'Fev';
            break;
        case 'Mar':
            return 'Mar';
            break;
        case 'Apr':
            return 'Abr';
            break;
        case 'May':
            return 'Mai';
            break;
        case 'Jun':
            return 'Jun';
            break;
        case 'Jul':
            return 'Jul';
            break;
        case 'Aug':
            return 'Ago';
            break;
        case 'Sep':
            return 'Set';
            break;
        case 'Oct':
            return 'Out';
            break;
        case 'Nov':
            return 'Nov';
            break;
        case 'Dec':
            return 'Dez';
            break;
    }
}




function weekDayTruncateConverterToPortuguese($week)
{
    switch ($week) {
                case 'Sun':
                    return 'Dom';
                    break;
                case 'Mon':
                    return 'Seg';
                    break;
                case 'Tue':
                    return 'Ter';
                    break;
                case 'Wed':
                    return 'Qua';
                    break;
                case 'Thu':
                    return 'Qui';
                    break;
                case 'Fri':
                    return 'Sex';
                    break;
                case 'Sat':
                    return 'Sáb';
                    break;
            }
}








// function weekDayConverterToPortuguese($week)
// {
//     switch ($week) {
//         case 'Sunday':
//             return 'Domingo';
//             break;
//         case 'Monday':
//             return 'Segunda-feira';
//             break;
//         case 'Tuesday':
//             return 'Terça-feira';
//             break;
//         case 'Wednesday':
//             return 'Quarta-feira';
//             break;
//         case 'Thursday':
//             return 'Quinta-feira';
//             break;
//         case 'Friday':
//             return 'Sexta-feira';
//             break;
//         case 'Saturday':
//             return 'Sábado';
//             break;
//     }
// }




function familiarDietaKeto($answer)
{
    switch ($answer) {
        case 1:
            return 'Não faço idéia de como funcione';
            break;
        case 2:
            return 'Já escutei falar';
            break;
        case 'March':
            return 'Já conheço';
            break;
    }
}


function tempoParaCozinhar($answer)
{
    switch ($answer) {
        case 1:
            return '30 min';
            break;
        case 2:
            return '1 hora';
            break;
        case 3:
            return 'Mais de 1 hora';
            break;
        case 4:
            return 'Tenho alguém';
            break;
    }
}

function veganoOuVegetariano($answer)
{
    switch ($answer) {
        case 1:
            return 'Vegano';
            break;
        case 2:
            return 'Vegetariano';
            break;
    }
}

function dispostoPerderPeso($answer)
{
    switch ($answer) {
        case 1:
            return 'Muito determinado';
            break;
        case 2:
            return 'Apenas quero testar a dieta keto';
            break;
        case 3:
            return 'Só quero perder uns quilinhos';
            break;
    }
}    



function praticaEsportes($answer)
{
    switch ($answer) {
        case 1:
            return '2 dias por semana';
            break;
        case 2:
            return '3 dias por semana';
            break;
        case 3:
            return 'Mais de 3 dias por semana';
            break;
        case 4:
            return 'Não faço esportes';
            break;

    }
}        

