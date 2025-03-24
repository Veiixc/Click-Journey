<?php
function getUserReservations($user_id) {
    $reservations = [];
    $csvPath = __DIR__ . '/../data/reservations.csv';
    



    
    if (file_exists($csvPath)) {
        if (($handle = fopen($csvPath, "r")) !== FALSE) {
        
            fgetcsv($handle);
            
            while (($data = fgetcsv($handle)) !== FALSE) {
                if ($data[0] === $user_id) {







                    $reservations[] = [

                        
                        'circuit_id' => $data[1],
                        'date_reservation' => $data[2],
                        'stages' => json_decode($data[3], true)
                    ];
                }
            }
            fclose($handle);
        }
    }
    
    return $reservations;
}
?>
