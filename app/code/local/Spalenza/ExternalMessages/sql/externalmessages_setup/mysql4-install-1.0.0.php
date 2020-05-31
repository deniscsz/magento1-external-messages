<?php
/**
 * External Messages.
 * Generate custom transactions messages based on templates to export to third senders
 *
 * @category  Spalenza
 * @package   Spalenza_ExternalMessages
 * @author    Denis Colli Spalenza <deniscsz@gmail.com>
 * @license   https://opensource.org/licenses/OSL-3.0.php Open Software License 3.0
 */

/** @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$tableMessage = $installer
    ->getConnection()
    ->newTable( $installer->getTable( 'externalmessages/message' ) )
    ->addColumn(
        'message_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'primary'  => true,
            'nullable' => false,
            'unsigned' => true
        ),
        'Message Id'
    )
    ->addColumn(
        'recipient',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => false,
        ),
        'Recipient'
    )
    ->addColumn(
        'message',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable'  => false
        ),
        'Body message'
    )
    ->addColumn(
        'type',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => false
        ),
        'Type of message'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array( 'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT ),
        'Created at this time'
    )
    ->addColumn(
        'sent_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Sent at this time'
    )
;

$installer->getConnection()->createTable( $tableMessage );


$tableTemplate = $installer
    ->getConnection()
    ->newTable( $installer->getTable( 'externalmessages/template' ) )
    ->addColumn(
        'template_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'primary'  => true,
            'nullable' => false,
            'unsigned' => true
        ),
        'Template Id'
    )
    ->addColumn(
        'title',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => false,
        ),
        'Title'
    )
    ->addColumn(
        'content',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable'  => false
        ),
        'Template content body'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'nullable'  => false,
            'default'  => 0
        ),
        'Template content body'
    )
    ->addColumn(
        'rule',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => false
        ),
        'Rule'
    )
;

$installer->getConnection()->createTable( $tableTemplate );

$installer->endSetup();
