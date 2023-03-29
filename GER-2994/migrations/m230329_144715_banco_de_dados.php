<?php

use yii\db\Migration;

use function PHPUnit\Framework\stringContains;

/**
 * Class m230329_144715_banco_de_dados
 */
class m230329_144715_banco_de_dados extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clientes}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(255)->notNull(),
            'cpf' => $this->string(15)->notNull(),
            'data_nasc' => $this->dateTime()->notNull(),
            'telefone' => $this->string(15),
            'ativo' => $this->tinyInteger()->notNull()
        ]);

        $this->createTable('{{%pedidos}}', [
            'id' => $this->primaryKey(),
            'produto' => $this->string(255)->notNull(),
            'valor' => $this->decimal(10,2)->notNull(),
            'data' => $this->dateTime()->notNull(),
            'cliente_id' => $this->integer(),
            'pedido_status_id' => $this->integer()->notNull(),
            'ativo' => $this->tinyInteger()->notNull()
        ]);

        $this->createTable('{{%pedido_status}}', [
            'id' => $this->primaryKey(),
            'descricao' => $this->string(255)->notNull(),
        ]);

        $this->createTable('{{%pedido_imagens}}', [
            'id' => $this->primaryKey(),
            'pedido_id' => $this->integer()->notNull(),
            'imagem' => $this->string(255),
            'capa' => $this->string(255)
        ]);

        $this->addForeignKey(
            'fk-pedidos-cliente_id',
            'pedidos',
            'cliente_id',
            'clientes',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-pedidos-pedido_status_id',
            'pedidos',
            'pedido_status_id',
            'pedido_status',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-pedido_imagens-pedido_id',
            'pedido_imagens',
            'pedido_id',
            'pedidos',
            'id',
            'CASCADE'
        );

        $this->batchInsert('{{%pedido_status}}', ['descricao'], [
            ['Solicitado'],
            ['Concluído'],
            ['Cancelado']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clientes}}');
        $this->dropTable('{{%pedidos}}');
        $this->dropTable('{{%pedido_status}}');
        $this->dropTable('{{%pedido_imagens}}');

    }
}
