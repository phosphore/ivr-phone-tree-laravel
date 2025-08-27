<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse as Twiml;

class IvrController extends Controller
{
    public function welcome()
    {
        $response = new Twiml();

        $response->say(
            "Benvenuti al Ministero dell'Istruzione e del Merito, Ufficio Scolastico Regionale per il Veneto. " .
            "Rimanga in linea per l'identificazione automatica tramite codice fiscale... " .
            "Pronunci di seguito il Suo codice fiscale.",
            ['voice' => 'Polly.Carla', 'language' => 'it-IT']
        );

        $response->pause(['length' => 12]);

        $response->say(
            "Benvenuta PAOLA POLATO. " .
            "Abbiamo rilevato che il chiamante potrebbe avere più di sessanta anni in base alla banca dati corrente. " .
            "Vuole proseguire col percorso digitale? Prema 1. " .
            "Per assistenza presso l'ufficio più vicino prema 2. " .
            "Per ascoltare un orientamento per over sessanta prema 3. " .
            "Per delegare un conoscente più giovane prema 4.",
            ['voice' => 'Polly.Carla', 'language' => 'it-IT']
        );

        return $response;
    }

    public function ageResponse(Request $request)
    {
        $digit = $request->input('Digits');
        $response = new Twiml();

        switch ($digit) {
            case '1':
                $response->say(
                    "Si ricorda che la scelta é a proprio rischio. Se per caso è davvero rincoglionita dalla vecchiaia e ha selezionato l'opzione errata, può semplicemente riagganciare e ricominciare il percorso.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                $response->redirect(route('main-menu', [], false));
                break;
            case '2':
                $response->say(
                    "Per trovare l'ufficio più vicino digiti il Suo CAP a cinque cifre. Se non lo ricorda prema 0 per ascoltare tutti i CAP del Veneto in ordine alfabetico. La prima disponibilità utile risulta: 8 febbraio duemila ventisette. Tempo stimato di attesa quarantasette minuti.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                $response->redirect(route('main-menu', [], false));
                break;
            case '3':
                $response->say(
                    "Servizi digitali per over sessanta. Numero uno: stampa del modulo digitale in formato cartaceo davanti a uno sportello. Numero due: appuntamento online per prenotare l'appuntamento in presenza. Numero tre: corso accelerato su SPID, C I E, P I N e altri acronimi motivazionali. Prema asterisco per tornare indietro.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                $response->redirect(route('main-menu', [], false));
                break;
            case '4':
                $response->say(
                    "Per delegare un nipote serve modulo D-12 firmato dal nipote e contromarcato dal coniuge, se ancora in vita. Il modulo è disponibile solo online in orario di chiusura. Prema asterisco per tornare indietro.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                $response->redirect(route('main-menu', [], false));
                break;
            default:
                $response->say(
                    "Scelta non valida.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                $response->redirect(route('welcome', [], false));
        }

        return $response;
    }

    public function mainMenu()
    {
        $response = new Twiml();
        $gather = $response->gather([
            'numDigits' => 2,
            'action' => route('main-response', [], false),
            'method' => 'POST',
            'timeout' => 5,
            'finishOnKey' => '',
        ]);
        $gather->say(
            "Menu principale. Per parlare con un operatore umano prema 1. Per stato pratica con numero di protocollo a ventidue cifre prema 2. Per appuntamenti prema 3. Per il bonus apparecchi acustici duemila ventiquattro prema 4. Per ufficio legale prema 5. Per pensioni prema 6. Per reclami prema 7. Per ascoltare l'informativa privacy prema 0. Per SPID prema cancelletto. Per tornare a questo menu prema asterisco. Per ricominciare da capo prema sette sette.",
            ['voice' => 'Polly.Carla', 'language' => 'it-IT']
        );

        return $response;
    }

    public function mainResponse(Request $request)
    {
        $digits = $request->input('Digits');
        $response = new Twiml();

        switch ($digits) {
            case '1':
                $response->say(
                    "La stiamo collegando con un operatore. Il Suo posto in coda è al numero 36. Rimanga in linea per non perdere la priorità acquisita. La preghiamo di attendere.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '2':
                $response->say(
                    "Inserisca il numero di protocollo a ventidue cifre seguito da cancelletto. In alternativa prema asterisco per tornare al menu.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '3':
                $response->say(
                    "Per prenotare un appuntamento compili prima il modulo di prenotazione dell'appuntamento per prenotare il modulo di prenotazione. Per ricevere il modulo è necessario inviare una richiesta firmata digitalmente con firma autografa.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '4':
                $response->say(
                    "Per il bonus servono: codice C U P alfanumerico di quindici caratteri seguito da due vocali, certificato di rumorosità domestica e autocertificazione di non avere ausili all'udito amministrativi. In alternativa può presentare una marca da bollo digitale stampata per ricevere lo sconto sul bonus.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '5':
                $response->say(
                    "Ufficio legale. Per pareri vincolanti non vincolanti lasci un messaggio dopo il segnale. Verrà richiamato entro ottanta giorni lavorativi.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '6':
                $response->say(
                    "Ricalcolo pensioni. Inserisca età anagrafica in anni scolastici e i minuti di intervallo maturati dal duemila ventitré a oggi. Eventuali minuti eccedenti verranno recuperati a fine carriera ai sensi della circolare Interv-23.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '7':
                $response->say(
                    "Reclami. Il Suo reclamo verrà protocollato, ascoltato, contemplato e forse compreso. Lasci un messaggio dopo il segnale.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '8':
                $response->say(
                    "Per certificare di aver perso la certificazione di smarrimento, presenti la copia conforme dell'originale mancante. Per assistenza prema asterisco.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '0':
                $response->say(
                    "Informativa privacy. Articolo uno: principi generali. Noi trattiamo i dati con cura, diligenza e spirito di servizio. La lettura integrale dura diciannove minuti (oggi gliela risparmiamo).",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '#':
                $response->say(
                    "Autenticazione SPID cantata. Intoni il Suo codice fiscale in do maggiore dopo il segnale. Per modulare in fa diesis prema 2 durante la registrazione. Prema asterisco per tornare indietro.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '*':
                $response->say(
                    "Torna al menu principale.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                $response->redirect(route('main-menu', [], false));
                return $response;
            case '77':
                $response->say(
                    "Ricomincia. Riproduzione del messaggio di benvenuto in corso.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                $response->redirect(route('welcome', [], false));
                return $response;
            case '42':
                $response->say(
                    "Il senso della vita è quarantadue. Per approfondimenti si rivolga al docente di matematica con delega filosofica.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            case '33':
                $response->say(
                    "Assessorato al tempo perso. In questo momento stiamo valutando il valore didattico dell'attesa. Rimanga in linea per migliorare il punteggio di educazione civica. Prema asterisco per tornare al menu.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                break;
            default:
                $response->say(
                    "Scelta non valida.",
                    ['voice' => 'Polly.Carla', 'language' => 'it-IT']
                );
                $response->redirect(route('main-menu', [], false));
                return $response;
        }

        return $response;
    }
}
