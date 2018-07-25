## Rhenus WMS

A PHP library to communication with Rhenus Logistics Warehouse Management System (WMS).

The library based on specification "General Interface Definition Customer System/Rhenus WMS Version 1.4".

The data files are transferred by means of FTP or SFTP.

## Message types

The following types for communication Customer -> Rhenus are possible:

| Message type | Comment |
| --- | --- |
| AR | Article master data |
| AVIS | Advice |
| BEST | Purchase order |
| AUF | Orders |

The following types for communication Rhenus -> Customer are possible:

| Message type | Comment |
| --- | --- |
| RAVIS | Advice confirmation |
| RAUF | Orders confirmation |
| BEW | Confirmation on general movements as well as goods receipt entries for purchase orders |
| BESTAND | Stock comparison |

## Usage Instructions

### AR message (Customer -> Rhenus)
```php
<?php
    use Scand\RhenusWMS\Message;
    use Scand\RhenusWMS\Messages\Files\FileTypeInterface;
    use Scand\RhenusWMS\Messages\Segments\Segment;
    use Scand\RhenusWMS\Messages\Segments\SegmentInterface;

    /** @var $messageAR \Scand\RhenusWMS\Messages\Types\AR */
    $messageAR = Message::factory(FileTypeInterface::FILE_TYPE_ARTICLE);

    /** @var $segmentAR \Scand\RhenusWMS\Messages\Segments\Types\AR */
    $segmentAR = Segment::factory(SegmentInterface::TYPE_AR);
    $segmentAR->setAttributeValue('branch', '11');
    $segmentAR->setAttributeValue('client', '15');
    $segmentAR->setAttributeValue('sub_client', '04');
    $segmentAR->setAttributeValue('article_number', '1233421');
    $segmentAR->setAttributeValue('type', 'NORM');
    $segmentAR->setAttributeValue('mandatory_ean', 'N');
    $segmentAR->setAttributeValue('mandatory_batch', 'J');
    $segmentAR->setAttributeValue('mandatory_ed', 'N');
    $segmentAR->setAttributeValue('mandatory_supplier', 'N');
    $segmentAR->setAttributeValue('mandatory_s_n', 'J');
    $segmentAR->setAttributeValue('brand_name', 'Brand Name');
    $segmentAR->setAttributeValue('brand_number', '234');
    $segmentAR->setAttributeValue('hazardous_attribute', 'N');
    $segmentAR->setAttributeValue('origin_country', 'CN');
    $segmentAR->setAttributeValue('tariff_number', 'CustomTariff3546');
    $messageAR->addSegment($segmentAR);

    /** @var $segmentText \Scand\RhenusWMS\Messages\Segments\Types\AR_TEXT */
    $segmentText = Segment::factory(SegmentInterface::TYPE_AR_TEXT);
    $segmentText->setAttributeValue('text', 'dies ist ein Text 1');
    $segmentText->setAttributeValue('language',  'DE');
    $messageAR->addSegment($segmentText);

    $segmentText = Segment::factory(SegmentInterface::TYPE_AR_TEXT);
    $segmentText->setAttributeValue('text', 'this is a text 1');
    $segmentText->setAttributeValue('language', 'EN');
    $messageAR->addSegment($segmentText);

    $segmentText = Segment::factory(SegmentInterface::TYPE_AR_TEXT);
    $segmentText->setAttributeValue('text', 'se trata de un texto 1');
    $segmentText->setAttributeValue('language', 'ES');
    $messageAR->addSegment($segmentText);

    /** @var $segmentLog \Scand\RhenusWMS\Messages\Segments\Types\AR_LOG_EINH */
    $segmentLog = Segment::factory(SegmentInterface::TYPE_AR_LOG_EINH);
    $segmentLog->setAttributeValue('quantity_unit', 'ST');
    $segmentLog->setAttributeValue('length', 50);
    $segmentLog->setAttributeValue('width', 50);
    $segmentLog->setAttributeValue('height', 50);
    $segmentLog->setAttributeValue('weight', 200);
    $segmentLog->setAttributeValue('base_quantity_attribute', 'J');
    $segmentLog->setAttributeValue('number_quantity_unit', 1);
    $messageAR->addSegment($segmentLog);

    /** @var $segmentEan \Scand\RhenusWMS\Messages\Segments\Types\AR_EAN */
    $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
    $segmentEan->setAttributeValue('code', '4006381333931');
    $messageAR->addSegment($segmentEan);

    $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
    $segmentEan->setAttributeValue('code', '4003994155486');
    $messageAR->addSegment($segmentEan);

    $segmentLog = Segment::factory(SegmentInterface::TYPE_AR_LOG_EINH);
    $segmentLog->setAttributeValue('quantity_unit', 'VE');
    $segmentLog->setAttributeValue('length', 250);
    $segmentLog->setAttributeValue('width', 50);
    $segmentLog->setAttributeValue('height', 100);
    $segmentLog->setAttributeValue('weight', 2000);
    $segmentLog->setAttributeValue('base_quantity_attribute', 'N');
    $segmentLog->setAttributeValue('number_quantity_unit', 10);
    $messageAR->addSegment($segmentLog);

    $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
    $segmentEan->setAttributeValue('code', '4006366333931');
    $messageAR->addSegment($segmentEan);

    $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
    $segmentEan->setAttributeValue('code', '4003994155111');
    $messageAR->addSegment($segmentEan);

    $segmentEan = Segment::factory(SegmentInterface::TYPE_AR_EAN);
    $segmentEan->setAttributeValue('code', '4002394155111');
    $messageAR->addSegment($segmentEan);

    /** @var $segmentZusInfo \Scand\RhenusWMS\Messages\Segments\Types\AR_ZUS_INFO */
    $segmentZusInfo = Segment::factory(SegmentInterface::TYPE_AR_ZUS_INFO);
    $segmentZusInfo->setAttributeValue('zus_info3', 'Zus Info 3');
    $segmentZusInfo->setAttributeValue('zus_info9', 'Zus Info 9');
    $messageAR->addSegment($segmentZusInfo);

    $csv = $message->toCSV();
```

### BEW message (Rhenus -> Customer)
```php
<?php
    use Logistic\StockTransfer;
    use Scand\RhenusWMS\Message;

    $file_path = dirname(__FILE__) . '/data/valid/BEW181300000000001.csv';
    /** @var $line \Scand\RhenusWMS\Messages\Types\BEW */
    $message = Message::createFromFile($file_path);
    $segments = $message->getSegments();
    /** @var $segment \Scand\RhenusWMS\Messages\Segments\Types\BEW */
    $segment = $segments[0];
    $stockTransfer = new StockTransfer();
    $stockTransfer->fromItemCode = $segment->getAttributeValue('from_article_number');
    $stockTransfer->toItemCode = $segment->getAttributeValue('to_article_number');
    $stockTransfer->fromStockType = $segment->getAttributeValue('from_stock_type');
    $stockTransfer->toStockType = $segment->getAttributeValue('to_stock_type');
    $stockTransfer->quantity = $segment->getAttributeValue('quantity');
    $stockTransfer->text = $segment->getAttributeValue('document_text');
    $stockTransfer->typeOfMovement = $segment->getAttributeValue('movement_type');
    $stockTransfer->zusInfo1 = $segment->getAttributeValue('zus_info1');
    $stockTransfer->zusInfo2 = $segment->getAttributeValue('zus_info2');
    $stockTransfer->save();
```

## Run code tests
```
composer test
```
