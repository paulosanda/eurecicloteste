#!/usr/bin/php

<?php
/**
 * Teste realizado por Paulo Sanda
 * email: paulosanda@gmail.com
 * WhatsApp: (18) 99154 3620
 * Idade: 52 anos
 * 
 * Para executar este teste é preciso ter o PHP instado 
 * Ele foi escrito para ser executado em Linux Shell
 * é preciso estar no diretório ou indicar o path para ele
 * Para executar basta digiar 
 * php teste.php
 * 
 * Obrigado
 */

function gen_nos(&$set, &$results) 
{
    for($i=0; $i<count($set); $i++)
    {
        $results[] = $set[$i];
        $tempset = $set;
        array_splice($tempset, $i, 1);
        $tempresults = array();
        gen_nos($tempset, $tempresults);
        foreach($tempresults as $res)
        {
            $results[] = $set[$i] .','. $res;
        }
    }
}


#carrega volume do galão
$galao = readline("Digite o volume do galao em litros: ");
#carrrega numero de garrafas
$num_garrafas = readline("Quantas garrafas ira usar? ");
#carrega volumes das garrafas
$garrafa = array();
$indice = 1;

for ($i=0; $i < $num_garrafas; $i++)
{
    
    $volume = readline("Digite o valor da garrafa ".$indice. " ");
    $volume = floatval($volume);
    array_push($garrafa,$volume);
    $indice++;

}

#calculo de combinações mesmo que repetidas
$results = array();
gen_nos($garrafa, $results);

#contando número de possibilidades
$possib = count($results);

#fazendo laço para resultados
$resumos = array();
foreach($results AS $r)
{   
    $dados = array();
    $calculo = array();
    $vols = array();
    if(is_float($r)){ 
        $vols = array($r);
        $saldo = $r - $galao;
        $dados = ([
            'vols' => $vols,
            'quantidade'    => 1,
            'total'         => $r,
            'saldo'         => $saldo
        ]);

        if($dados['total'] >= $galao){
            array_push($resumos,$dados);
        }
        
    } else {
        $calculo = explode(',',$r);
        $soma = array_sum($calculo);
        $saldo = $soma - $galao;
        $vols = $calculo;
        $dados = ([
            'vols' => $r,
            'quantidade'    => count($calculo),
            'total'         => $soma,
            'saldo'         => $saldo
        ]);

        if($dados['total'] >= $galao){
            array_push($resumos,$dados);
        }
        
    }
   
}

//inserindo os saldos em uma array para comparação
$saldos = array();
foreach($resumos AS $res)
{
    array_push($saldos, $res['saldo']);
}

//criando array com menor resultados
$menor_saldo =  min($saldos);
$finalres = array();
foreach($resumos AS $fim)
{
    if($fim['saldo'] == $menor_saldo){
       $nsaldo = ([
            'vols'      =>$fim['vols'],
            'quantidade'=>$fim['quantidade'],
            'total'     =>$fim['total'],
            'saldo'     =>$fim['saldo']
        ]);
        array_push($finalres, $nsaldo);
    } 
}
//var_dump($resposta);
//echo 'Resposta: '."[".$resposta[0]['vols']."]".' , '.' sobra '.$resposta[0]['saldo'];
//echo "/n";
foreach($finalres AS $fg)
{
    array_push($qtidadegarrafas,$fg['quantidade']);
}

//criando array com menor quantidade de garrafas
$menosgarrafas = min($qtidadegarrafas);
$resposta = array();
foreach($finalres AS $fr)
{
    if($fr['quantidade'] == $menosgarrafas){
        $gdados = ([
            'vols'      =>$fr['vols'],
            'quantidade'=>$fr['quantidade'],
            'total'     =>$fr['total'],
            'saldo'     =>$fr['saldo']
        ]);
        array_push($resposta,$gdados);
    }
}

echo 'Resposta: [';
$respostas = explode(',', $resposta[0]['vols']);
foreach($respostas AS $rs){
    echo " ".$rs.'lts';
}
echo "] sobra ".$resposta[0]['saldo'];

?>
