<?php
require_once __DIR__ . '/config/database.php';

try {
    $db = Database::getInstance();
    
    // Update Tata Power Solar 330W Panel price to 6,600 (330W @ Rs 20/watt) and old_price to 8,200
    $stmt_t = $db->prepare("UPDATE products SET price = 6600.00, old_price = 8200.00 WHERE id = 2 OR slug = 'tata-power-330w-poly'");
    $stmt_t->execute();

    // Update Havells Enviro 5kW Hybrid Inverter price to 68,000 and old_price to 75,000
    $stmt_h = $db->prepare("UPDATE products SET price = 68000.00, old_price = 75000.00 WHERE id = 3 OR slug = 'havells-enviro-5kw-hybrid'");
    $stmt_h->execute();

    // Update Luminous NXG 1800 Inverter price to 25,000 and old_price to 28,500
    $stmt0 = $db->prepare("UPDATE products SET price = 25000.00, old_price = 28500.00 WHERE id = 4 OR slug = 'luminous-nxg-1800-24v'");
    $stmt0->execute();

    // Update Luminous Battery 150Ah price to 11,999 and old_price to 14,500
    $stmt1 = $db->prepare("UPDATE products SET price = 11999.00, old_price = 14500.00 WHERE id = 5 OR slug = 'luminous-solar-150ah-battery'");
    $stmt1->execute();

    // Update Street Light price to 12,800 and old_price to 14,500
    $stmt2 = $db->prepare("UPDATE products SET price = 12800.00, old_price = 14500.00 WHERE id = 7 OR slug = 'integrated-solar-street-light-30w'");
    $stmt2->execute();

    // Update Solar Water Heater price to 49,200 and old_price to 54,000
    $stmt3 = $db->prepare("UPDATE products SET price = 49200.00, old_price = 54000.00 WHERE id = 6 OR slug = 'supreme-200l-solar-water-heater'");
    $stmt3->execute();

    echo "Prices updated successfully in Database!\n";
    
    $stmt = $db->query("SELECT id, name, price, old_price FROM products WHERE id IN (2,3,4,5,6,7)");
    print_r($stmt->fetchAll());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
