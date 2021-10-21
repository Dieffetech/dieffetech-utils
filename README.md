# dieffetech-utils
 Raccolta di utilities per i nostri progetti.
 ##### per installare la libreria e le varie util basta lanciare il seguente comando:
````php
composer require kristianlentino/dieffetech-utils
````
_______
# Array Utils
 1. `getArrayForSelect` --> funzione per comporre una query che ritorni dati per le select2
 ```php
    ArrayUtil::getArrayForSelect(
        get_class(new Admin()),
        ['adminid',"CONCAT(admin.surname,' ',admin.name,' - ', admin.email) as name"],
        null,
        null,
        'adminid',
        'name',
        0,
        'name'
    ); 
```
2. `transformArrayModelsToSelect` --> Trasforma un array di model che estendono la classe Model in un array per la select2 in base al tipo di select2
     ```php
    ArrayUtil::transformArrayModelsToSelect($models,0,'templateid','name')
    ```
3. `array_flatten` --> riduce di una dimensione un array multidimensionale
    ````php
        $arrayErrors = [
            'message' => [
                'name' => 'Kristian',
                'surname' => 'Lentino'
            ]    
        ];
        $messages = ArrayUtil::array_flatten($arrayErrors, false);
      
        //il risultato di questa operazione é :
        Array
       (
         [name] => Kristian
         [surname] => Lentino
       )

    ````
4. `addQuotesToArrayElements` --> Aggiunge gli apici a tutti gli elementi di un array semplice monodimensionale, è molto utile quando devi fare in una query una clausola IN con più stringhe o date,essendo una util con referenza non è necessario il return, l'array verrà modificato direttamente 
  ````php
    $types = ['Prova','Kristian','Ciao'];
	ArrayUtil::addQuotesToArrayElements($types);
	//senza aggiungere gli apici un'operazione come quella sotto darebbe errore 
    $this->special_courses = Courses::getAll([
         'type' => [
             'operation' => 'IN',
             'value' => "(". implode(',',$types) .")"
         ],
         'useridfk' => $this->userid
    ]); 
  ````
5. `downCaseArrayElements` --> trasforma un array di string tutte in minuscole ,essendo una util con referenza non è necessario il return, l'array verrà modificato direttamente
  ````php
    $types = ['CIAOOO','PROVAAA','DIEFFETECH'];
	ArrayUtil::downCaseArrayElements($types);
	//types ora avrà come valori : ['ciao','prova','dieffetech'] 
  ````
6. `trimArrayElements` --> rimuove in un array di string gli spazi ,essendo una util con referenza non è necessario il return, l'array verrà modificato direttamente
  ````php
    $types = ['CIA   OOO','PROVA  AA','DIEFFE  TECH'];
	ArrayUtil::trimArrayElements($types);
	//types ora avrà come valori : ['CIAO','PROVAAA','DIEFFETECH'] 
  ````
7. `usortByColValue` --> ordina un array in base al valore di una delle colonne (solo per array multidimensionali) ,essendo una util con referenza non è necessario il return, l'array verrà modificato direttamente
  ````php
    $names = [
        0 => ['name' => 'Kristian'],
        1 => ['name' => 'Christian'],
        2 => ['name' => 'Alessandro'],
        3 => ['name' => 'Antonino'],
    ];
    //di default ordine in ordine ASC
	ArrayUtil::usortByColValue($names,'name');
    //risultato
    Array
(
    [0] => Array
        (
            [name] => Alessandro
        )

    [1] => Array
        (
            [name] => Antonino
        )

    [2] => Array
        (
            [name] => Christian
        )

    [3] => Array
        (
            [name] => Kristian
        )

)

  ````
8. `remove_element_recursive` --> permette di rimuovere da un array le chiavi scelte per un array monodimensionale, essendo con referenza i valori dell'array vengono modificati direttamente
  ````php
    $types = [
        0 => ['name' => 'kris','surname' => 'lentino'],
        1 => ['name' => 'Antonino','surname' => 'Cirruto'],
    ];
	ArrayUtil::remove_element_recursive($types,'surname');
	/*
	 * types ora avrà come valori : [
	 *  0 => [
	 *      'name' => 'kris'
	 *  ],
	 *  1 => [
	 *      'name' => 'Antonino'
	 *  ]
	 * ]
	 */ 
  ````
9. `array_first_key` --> ritorna la prima chiave dell'array
  ````php
    $types = [
        0 => ['name' => 'kris','surname' => 'lentino'],
        1 => ['name' => 'Antonino','surname' => 'Cirruto'],
    ];
	ArrayUtil::array_first_key($types);
	//tornerà 0 
  ````

# Console utils

1. `runCron` --> permette di eseguire un cron, questo può essere utile ad esempio per un invio massivo di email
  ````php
    ConsoleUtil::runCron('cron/revert-student',[$this->userid]);
	//lancerà il cron revert-student passandogli come parametro l'id dell'utente 
  ````
# Dates utils

1. `getDatesInRange` --> permette di ottenere un array contenente le date entro un certo range
  ````php
    $dateStart = '2021-09-10';
    $dateEnd = '2021-09-18';
    $datesInRange = DatesUtil::getDatesInRange($dateStart,$dateEnd);
	/**
    *  tornerà il seguente array :
    * Array
      (
          [0] => 2021-09-10
          [1] => 2021-09-11
          [2] => 2021-09-12
          [3] => 2021-09-13
          [4] => 2021-09-14
          [5] => 2021-09-15
          [6] => 2021-09-16
          [7] => 2021-09-17
          [8] => 2021-09-18
      )
    * 
    */
  ````
2. `convertDate` --> Converte una data in formato italiano, convertDateTime fa la stessa cosa ma in più ha anche le ore e minuti
    ````php
    $dateStart = '2021-09-10';
    $dateStartItaliano = DatesUtil::convertDate($dateStart);
    /**
    *  tornerà la seguente data : 10/09/2021 
    */

3. `convertDateToSql` --> Converte una data in formato americano, convertDateTimeToSql fa la stessa cosa ma in più ha anche le ore,minuti e secondi
    ````php
    $dateStart = '10/09/2021';
    $dateStartAmericano = DatesUtil::convertDateToSql($dateStart);
    /**
    *  tornerà la seguente data : 2021-09-10 
    */
  
4. `convertDateToSql` --> Converte una data in formato americano, convertDateTimeToSql fa la stessa cosa ma in più ha anche le ore,minuti e secondi
    ````php 
   $dateStart = '10/09/2021';
    $dateStartAmericano = DatesUtil::convertDateToSql($dateStart);
    /**
    *  tornerà la seguente data : 2021-09-10 
    */
5. `getDayOfThisWeek` --> Dato un nome di un giorno in inglese tutto minuscolo, torna quando cadrà quel giorno in questa settimana
    ````php
    $dayName = 'saturday';
    $dateSabato = DatesUtil::getDayOfThisWeek($dayName);
    
    /**
    *  tornerà la data del sabato di questa settimana, nel mio caso tornerà : 2021-09-25 
    */
  
6. `addRemoveToDate` --> permette di rimuovere o aggiungere giorni,mesi e anni ad una data
    ````php
    $paymentAggreements30 = DatesUtil::addRemoveToDate('2021-10-31','Y-m-d',[
         'days' => [
           'operation' => '-',
            'value' => 30
        ]
      ]);
   /**
     *  tornerà la data passata -30 giorni 
    */
   $plusOneYear = DatesUtil::addRemoveToDate('2021-10-31','Y-m-d',[
                'years' => [
                    'operation' => '+',
                    'value' => 1
                ]
      ]);
    
      /**
     *  tornerà la data passata come argomento +1 anno 
    */
  
7. `getLastDayOfMonth` --> torna l'ultimo giorno del mese dell'anno passato (se vuoto di quello corrente)
      ````php
         
         $lasstMonth = date('m');
         $lastDayOfMonth = DatesUtil::getLastDayOfMonth($lastMonth,$lastYear);
         /* ritornerà l'ultimo giorno del mese passato, se oggi è settembre tornerà  2021-09-30  */
8. `dateDiff` --> torna un oggetto DateInterval,entrambe devono essere in formato Y-m-d
      ````php
         $dateStart = '2021-09-10';
         $dateEnd = '2021-09-18';
         $diff = DatesUtil::dateDiff($dateEnd,$dateStart);
      
         /**
            DateInterval Object
          (
      [y] => 0
      [m] => 0
      [d] => 8
      [h] => 0
      [i] => 0
      [s] => 0
      [f] => 0
      [weekday] => 0
      [weekday_behavior] => 0
      [first_last_day_of] => 0
      [invert] => 0
      [days] => 8
      [special_type] => 0
      [special_amount] => 0
      [have_weekday_relative] => 0
      [have_special_relative] => 0
      )

         */
9. `getNextMonth` --> torna il mese prossimo

# Security Util
1. `encryptBykey` --> cripta una stringa o numero tramite l'algoritmo openssl_encrypt fornendo una chiave di criptaggio, questo è molto comodo quando in un frontend devi mettere in get un id, invece di metterlo in chiaro meglio criptarlo
2. `decryptBykey` --> Decripta una stringa o numero tramite l'algoritmo openssl_encrypt e la chiave di criptaggio settata nei params
# File Util
1. `deleteDirectory` --> elimina una cartella e tutti i file al suo interno
# Geolocation Util
1. `getCoordinates` --> dato un indirizzo nel formato via,civico,città (esempio Via rossi 83, Pavia) fa una chiamata alle api di google maps e torna la latituidine e la longitudine del posto, se esiste
# Google recaptcha Util
1. `validateCaptcha` -->  controlla che il captcha google (v3) inviato dal form sia valido
````php
   $captcha = GoogleRecaptcha::validateCaptcha(\Yii::$app->params["GOOGLE_CAPTCHA"]["SECRET"]);
````

# Image Utils
 1. `calculateAspectRatio` --> funzione calcolare l'aspect ratio (16/9  ecc..) di un'immagine date delle dimensioni 
 ```php
    /* torna 1.7777777777778 che sarebbe l'equivalente di dire 16/9 */
    ImageUtil::calculateAspectRatio(1920,1080);
    /* Per tornare la stringa 16:9 basta passare un terzo parametro a true come segue */
    ImageUtil::calculateAspectRatio(1920,1080,true);
```

# Regex Util
 Raccolta di regex util per validazioni dei campi nelle rules di yii
 ```php
    //Validazione date inserite correttamente nel formato italiano
    [['born_date','establishment_date'],'match','pattern' => RegexUtil::REGEX_VALID_DATE,'on' => self::SCENARIO_FORM],
    //Validazione link inserite correttamente
    [['website'],'match','pattern' => RegexUtil::REGEX_VALID_URL],
```
# Fiscal code validator
 Validator Yii2 per effettuare controlli di correttezza dei dati inseriti nel codice fiscale
 ```php
    //Validazione codice fiscale
    [['fiscal_code'],FiscalCodeValidator::className(),'when' => function($model){
				return $model->nationidfk == JobNation::ITALY_ID;
   },'on' => self::SCENARIO_VALIDATE],
```

# telephone validator
 Validator Yii2 per effettuare controlli di correttezza dei dati inseriti nel numero di telefono
 ```php
    //Validazione telefono
    [['telephone'],TelephoneValidator::class],
```
