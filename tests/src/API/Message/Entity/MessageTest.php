<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 04:18
 */

namespace API\Message\Entity;


class MessageTest  extends \PHPUnit_Framework_TestCase {

    public function testVerificaEncapsulamentoSetId()
    {
        $message = new Message();
        $message->setId(1);

        $this->assertEquals(1, $message->getId());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSeMetodoSetIdRetornaExcecaoAoSetarValorNaoInteiro()
    {
        $message = new Message();
        $message->setId('id');
    }


    public function testVerificaEncapsulamentoSetDescricao()
    {
        $message = new Message();
        $message->setMessage('message');

        $this->assertEquals('message', $message->getMessage());
    }

}