<?php

/**
 * Recebe e processa as informações de tensão.
 *
 * @param int $tensaoU Tensão U a ser processada.
 * @param int $tensaoV Tensão V a ser processada.
 * @param int $tensaoW Tensão W a ser processada.
 * @return void
 */
$tensaoU = filter_var($_REQUEST['TensaoU'], FILTER_VALIDATE_INT);
$tensaoV = filter_var($_REQUEST['TensaoV'], FILTER_VALIDATE_INT);
$tensaoW = filter_var($_REQUEST['TensaoW'], FILTER_VALIDATE_INT);

/**
 * Recebe e processa as informações de corrente.
 *
 * @param int $correnteU Corrente U a ser processada.
 * @param int $correnteV Corrente V a ser processada.
 * @param int $correnteW Corrente W a ser processada.
 */
$correnteU = filter_var($_REQUEST['CorrenteU'], FILTER_VALIDATE_INT);
$correnteV = filter_var($_REQUEST['CorrenteV'], FILTER_VALIDATE_INT);
$correnteW = filter_var($_REQUEST['CorrenteW'], FILTER_VALIDATE_INT);


/**
 * Recebe e processa as informações de potência.
 *
 * @param int $potU Potência U a ser processada.
 * @param int $potV Potência V a ser processada.
 * @param int $potW Potência W a ser processada.
 */
$potU = filter_var($_REQUEST['PotU'], FILTER_VALIDATE_INT);
$potV = filter_var($_REQUEST['PotV'], FILTER_VALIDATE_INT);
$potW = filter_var($_REQUEST['PotW'], FILTER_VALIDATE_INT);

/**
 * Função para criar um elemento do DOM com um texto
 *
 * @param DOMDocument $dom O objeto DOMDocument
 * @param string $tagName O nome da tag do elemento
 * @param string $text O texto a ser inserido no elemento
 * @return DOMElement O elemento do DOM criado
 */
function criaElementoTexto($dom, $tagName, $text) {
    $element = $dom->createElement($tagName);
    $element->appendChild($dom->createTextNode($text));
    return $element;
}

/**
 * Função para criar um nó de fases com os valores específicos de cada fase
 *
 * @param DOMDocument $dom O objeto DOMDocument
 * @param string $fase A descrição da fase
 * @param int $tensao O valor da tensão
 * @param int $corrente O valor da corrente
 * @param int $potencia O valor da potência
 * @return DOMElement O nó de fases criado
 */
function criaNodoFases($dom, $fase, $tensao, $corrente, $potencia) {
    $fasesNode = $dom->createElement('fases');
    $attrFase = $dom->createAttribute('descrição');
    $attrFase->value = $fase;
    $fasesNode->appendChild($attrFase);
    $fasesNode->appendChild(criaElementoTexto($dom, 'Tensão', $tensao));
    $fasesNode->appendChild(criaElementoTexto($dom, 'Corrente', $corrente));
    $fasesNode->appendChild(criaElementoTexto($dom, 'Potência', $potencia));
    return $fasesNode;
}

$dom = new DOMDocument('1.0', 'UTF-8');
$arquivoXML = 'medidasXML.xml';

$root = $dom->createElement('Fonte');
$root->appendChild(criaNodoFases($dom, 'fase1', $tensaoU, $correnteU, $potU));
$root->appendChild(criaNodoFases($dom, 'fase2', $tensaoV, $correnteV, $potV));
$root->appendChild(criaNodoFases($dom, 'fase3', $tensaoW, $correnteW, $potW));
$dom->appendChild($root);

$dom->save($arquivoXML);

