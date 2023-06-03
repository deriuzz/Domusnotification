<?php
// Leggi il payload inviato dal webhook come corpo della richiesta POST
$payload = file_get_contents('php://input');

// Decodifica il payload JSON in un oggetto PHP
$data = json_decode($payload);

// Verifica se l'evento che desideri gestire è presente nel payload
if ($data->event === 'booking_new_any_status') {
    // Ottieni i dati pertinenti dalla prenotazione
    $bookingId = $data->booking_id;
    $customerName = $data->customer_name;
    $arrivalDate = $data->arrival_date;

    // Esegui le operazioni necessarie con i dati della prenotazione
    // ad esempio, invio di una notifica tramite Twilio

    // Esempio di invio di una notifica SMS tramite Twilio
    $accountSid = 'TUO_ACCOUNT_SID';
    $authToken = 'TUO_AUTH_TOKEN';
    $twilioNumber = 'TUO_NUMERO_TWILIO';

    $client = new Twilio\Rest\Client($accountSid, $authToken);
    $message = $client->messages->create(
        'NUMERO_DESTINATARIO',
        [
            'from' => $twilioNumber,
            'body' => "Nuova prenotazione da {$customerName} il {$arrivalDate}."
        ]
    );

    // Gestisci eventuali errori nell'invio del messaggio Twilio
    if ($message->errorCode) {
        // Gestisci l'errore
    }

    // Invia una risposta al webhook per indicare che la richiesta è stata gestita correttamente
    http_response_code(200);
    echo 'OK';
} else {
    // L'evento non corrisponde a quello che ci aspettiamo, ignora la richiesta
    http_response_code(400);
    echo 'Bad Request';
}
?>
