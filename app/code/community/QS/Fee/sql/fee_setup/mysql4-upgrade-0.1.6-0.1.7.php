<?php

$installer = $this;

$installer->startSetup();

$inshurance_info_use_content = "
    <p style='font-size: 18px; font-weight: bold; color: #777; margin-bottom: 20px;'>Why use  U-PIC Parcel Insurance?</p>
    <ul style='list-style-position: inside; font-size: 18px; color: #777; font-weight: bold; '>
        <li style='display:inline-block; background: url({{skin url='images/li-icon.png'}}) no-repeat 5px 0px; padding-left: 70px; padding-bottom: 20px; width: 70%;'>Guaranteed delivery or your money back.</li>
        <li style='display:inline-block; background: url({{skin url='images/li-icon.png'}}) no-repeat 5px 0px; padding-left: 70px; padding-bottom: 20px; width: 70%;'>Guaranteed to arrive undamaged or your money back.</li>
        <li style='display:inline-block; background: url({{skin url='images/li-icon.png'}}) no-repeat 5px 0px; padding-left: 70px; padding-bottom: 20px; width: 70%;'>Guaranteed peace of mind.</li>
        <li style='display:inline-block; background: url({{skin url='images/li-icon.png'}}) no-repeat 5px 0px; padding-left: 70px; padding-bottom: 20px; width: 70%;'>Guaranteed 100% protection!</li>
        <p style='font-size: 12px; font-weight: bold; padding-left: 70px; color: #777;'>Insurance provided by an 'A'(Excellent) - A. M. Best and 'A' (Strong) - Standart & Poor's Insurance Company.</p>
    </ul>";

$stores = Mage::getModel('core/store')->getCollection()->addFieldToFilter('store_id', array('gt'=>0))->getAllIds();

foreach ($stores as $store){
    $block = Mage::getModel('cms/block');
    $block->setTitle('Inshurance info use');
    $block->setIdentifier('inshurance_info_use');
    $block->setStores(array($store));
    $block->setIsActive(1);
    $block->setContent($inshurance_info_use_content);
    $block->save();
}

$inshurance_info_rules_content = "
    <p style='font-size: 18px; font-weight: bold; color: #777; margin-bottom: 20px;'>Coverage Rules</p>
    <p style='font-size: 18px; font-weight: bold; color: #777; margin-bottom: 15px;'>U-PIC COVERAGE DOES NOT INSURE THE FOLLOWING</p>
    <ol style='font-size: 12px; color: #777; font-weight: bold; '>
        <li style='list-style-type:decimal;padding-left: 32px; padding-bottom: 18px; width: 72%;'>Accounts, bills, bullion, currency, deeds, evidence of debt, furs, original/fine art, computer chips, money, notes, securities, perishable cargo, precious/semi-precious stones, televisions, tickets, laptop computers, cellphones, personal goods, or similar property unless endorsed in writing.</li>
        <li style='list-style-type:decimal;padding-left: 32px; padding-bottom: 18px; width: 72%;'>Loss, damage, or non-arrival of any parcel which; (a) is addressed, wrapped or packed insufficiently, incorrectly or contrary to the carrier's packaging requirements; or (b) bears a descriptive label or packaging which tends to describe the nature of its contents.</li>
        <li style='list-style-type:decimal;padding-left: 32px; padding-bottom: 18px; width: 75%;'>Arising out of infidelity, dishonesty, or any overt act on the part of the Insured, associate in interest, and/or any of the Insured’s employees whether occurring during hours of employment or otherwise, nor on the part of custodians (common carriers excepted), or the property insured unless specifically endorsed hereon in writing.</li>
        <li style='list-style-type:decimal;padding-left: 32px; padding-bottom: 18px; width: 70%;'>Arising out of loss of market, latent defect, inherent vice, delay, loss of use, cleanup costs, decay, changes in temperature or humidity, or other deterioration, any remote or consequential loss, whether or not arising out of a peril insured against.</li>
        <li style='list-style-type:decimal;padding-left: 32px; padding-bottom: 18px; width: 70%;'>Afghanistan; Algeria; Angola (Cabinda); Belarus; Bosnia; Burma; Burundi; Cote d'Ivoire (Ivory Coast); Croatia; Cuba; Democratic Republic of the Congo; Herzegovina; Iran; Iraq; Jordan; Liberia; Libya, Moldova; Montenegro; Nigeria; North Korea; Paraguay; Republic of the Congo (Zaire); Serbia; Sierra Leone; Somalia; Sri Lanka; Sudan; Syria; Togo; Yemen; Zimbabwe <br>***Or any other country that is or may become embargoed by the United States or United Nations as sanctioned by the Office of Foreign Asset Control (OFAC).</li>
    </ol>";

$stores = Mage::getModel('core/store')->getCollection()->addFieldToFilter('store_id', array('gt'=>0))->getAllIds();

foreach ($stores as $store){
    $block = Mage::getModel('cms/block');
    $block->setTitle('Inshurance info rules');
    $block->setIdentifier('inshurance_info_rules');
    $block->setStores(array($store));
    $block->setIsActive(1);
    $block->setContent($inshurance_info_rules_content);
    $block->save();
}

$installer->endSetup();

