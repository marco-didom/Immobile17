<?php

/**
 * Class FUtente
 * Si occupa delle iterazioni con FDataBase per quanto riguarda gli oggetti MUtente
 * Poiché le tabelle cliente e agente_immobiliare possiedono gli stessi campi, le operazioni vengono svolte sull'una o sull'altra a seconda della tipologia di utente
 * Vengono utilizzate le sottoclassi FCliente e FAgenteImmobiliare per i parametri statici
 * @author Della Pelle - Di Domenica - Foderà
 * @package foundation
 */
class FUtente extends FObject
{
    private static string $values="(:id, :nome, :cognome, :datanascita, :mail, 
                                    :password, :iscrizione, :verifica)";

    /**
     * @param PDOStatement $stmt
     * @param $obj
     * @param string $newId
     */
    public static function bind(PDOStatement $stmt, $obj, string $newId): void
    {
        $stmt->bindValue(':id',          $newId,                                      PDO::PARAM_STR);
        $stmt->bindValue(':nome',        $obj->getNome(),                             PDO::PARAM_STR);
        $stmt->bindValue(':cognome',     $obj->getCognome(),                          PDO::PARAM_STR);
        $stmt->bindValue(':datanascita', $obj->getDataNascita()->getDateString(), PDO::PARAM_STR);
        $stmt->bindValue(':mail',        $obj->getEmail(),                            PDO::PARAM_STR);
        $stmt->bindValue(':password',    password_hash($obj->getPassword(), PASSWORD_BCRYPT),                         PDO::PARAM_STR);
        $stmt->bindValue(':iscrizione',  $obj->getIscrizione()->getDateString(),  PDO::PARAM_STR);
        $stmt->bindValue(':verifica',    $obj->isAttivato(),                          PDO::PARAM_BOOL);
    }

    /**
     * @return string
     */
    public static function getValues() :string
    {
        return self::$values;
    }

    /**
     * Chiama la di controllo dell'esistenza della mail nel DB su FCliente o FAgenteImmobiliare a seconda del formato della mail
     * @param string $mail
     * @return bool
     */
    public static function emailesistente(string $mail) :bool
    {
        $db = FDataBase::getInstance();
        if(strpos($mail, "@info.it"))
            return $db->existDB("FAgenteImmobiliare", "mail", $mail);
        else
            return $db->existDB("FCliente", "mail", $mail);
    }

    /**
     * Chiama la funzione di aggiunta al DB su FCliente o FAgenteImmobiliare
     * @param MUtente $utente
     * @return bool
     */
    public static function registrazione(MUtente $utente) :bool
    {
        $db= FDataBase::getInstance();
        if($utente instanceof MCliente)
            return $db->storeDb(FCliente::class, $utente);
        else if ($utente instanceof MAgenteImmobiliare)
            return $db->storeDb(FAgenteImmobiliare::class, $utente);
    }

    /**
     * Chiamata alla funzione di controllo della corrispondenza fra mail e password
     * Chiama la funzione loginCheck() su FCliente o FAgenteImmobiliare a seconda del formato della mail
     * @param string $mail
     * @param string $password
     * @return bool
     */
    public static function login(string $mail, string $password) :bool
    {
        $db = FDataBase::getInstance();
        if(strpos($mail, "@info.it"))
            $utenti = self::getUtenti('AGENTE');
        else $utenti = self::getUtenti('CLIENTE');
        foreach ($utenti as $utente)
        {
            if(password_verify($password, $utente->getPassword()))
                return true;
        }
        return false;
    }

    /**
     * Controlla che esista un Utente con l'Id passato come parametro
     * @param string $id
     * @return bool
     */
    public static function idEsistente(string $id) :bool
    {
        $db = FDataBase::getInstance();
        if(self::identifyId($id) === "CLIENTE")
            return $db->existDB(FCliente::class, "id", $id);
        else return $db->existDB(FAgenteImmobiliare::class, "id", $id);
    }

    /**
     * Ritorna l'Utente corrispondente all'Id passato come parametro
     * @param string $id
     * @return MUtente|null
     */
    public static function visualizzaUtente(string $id) :?MUtente
    {
        $db = FDataBase::getInstance();
        if(self::identifyId($id) === "CLIENTE") {
            $db_result = $db->loadDB(FCliente::class, "id", $id);
            $utente = new MCliente();
        }
        else {
            $db_result = $db->loadDB(FAgenteImmobiliare::class, "id", $id);
            $utente = new MAgenteImmobiliare();
        }

        if($db_result != null) {
            self::setAttributiUtente($utente, $db_result[0]);
            return $utente;
        }
        else return null;
    }

    /**
     * Imposta gli attributi di $utente con il contenuto di $db_result
     * @param MUtente $utente
     * @param array $db_result
     */
    public static function setAttributiUtente(MUtente $utente, array $db_result)
    {
        $utente->setId($db_result["id"]);
        $utente->setNome($db_result["nome"]);
        $utente->setCognome($db_result["cognome"]);
        $utente->setEmail($db_result["mail"]);
        $utente->setPassword($db_result["password"]);
        $utente->setDataNascita(MData::getMDataFromString($db_result["datanascita"]));
        $utente->setIscrizione(MData::getMDataFromString($db_result["iscrizione"]));
        $utente->setAttivato($db_result["verifica"]);
        if(FMedia::getMedia($utente->getId()) != null) {
            $utente->setImmagine(FMedia::getMedia($utente->getId())[0]);
            $utente->getImmagine()->setUtente($utente);
        }
    }

    /**
     * Modifica l'Utente con i valori del nuovo Utente
     * @param MUtente $utente
     * @return bool esito dell'operazione
     */
    public static function modificaUtente(MUtente $utente)
    {
        $db = FDataBase::getInstance();
        $oldUtente = FUtente::visualizzaUtente($utente->getId());
        $mods = array();
        if($utente->getNome() != $oldUtente->getNome())
            $mods["nome"] = $utente->getNome();
        if($utente->getCognome() != $oldUtente->getCognome())
            $mods["cognome"] = $utente->getCognome();
        if($utente->getEmail() != $oldUtente->getEmail())
            $mods["mail"] = $utente->getEmail();
        if($utente->getPassword() != $oldUtente->getPassword())
            $mods["password"] = password_hash($utente->getPassword(), PASSWORD_BCRYPT);
        if($utente->getDataNascita() != $oldUtente->getDataNascita())
            $mods["datanascita"] = $utente->getDataNascita()->getDateString();
        if($utente->getIscrizione() != $oldUtente->getIscrizione())
            $mods["iscrizione"] = $utente->getIscrizione()->getDateString();
        if($utente->isAttivato() != $oldUtente->isAttivato())
        {
            if(!$utente->isAttivato())
                $mods['verifica'] = 0;
            else $mods['verifica'] = 1;
        }

        foreach (array_keys($mods) as &$key)
        {
            if(strcmp(self::identifyId($utente->getId()), "CLIENTE")===0)
                $toReturn = $db->updateDB(FCliente::class, $key, $mods[$key], "id", $utente->getId());
            else
                $toReturn = $db->updateDB(FAgenteImmobiliare::class, $key, $mods[$key], "id", $utente->getId());
            if(!$toReturn)
                return false;
        }
        return true;
    }

    /**
     * Ritorna un MUtente con la lista appuntamenti completa
     * @param string $id
     * @return MUtente
     */
    public static function visualizzaAppUtente(string $id) :MUtente
    {
        $utente = self::visualizzaUtente($id);
        $utente->setListAppuntamenti(FAppuntamento::visualizzaAppOggetto($id));
        return $utente;
    }

    /**
     * Ritorna l'MUtente con la lista appuntamenti completa degli appuntamenti fra le due date
     * @param string $id
     * @param $inizio
     * @param $fine
     * @return MUtente
     */
    public static function AppUtenteInBetween(string $id, MData $inizio, MData $fine): MUtente{
        $utente = self::visualizzaUtente($id);
        $utente->setListAppuntamenti(FAppuntamento::getAppInBetween($id, $inizio, $fine));
        return $utente;
    }

    /**
     * Ritorna l'id dell'utente la cui mail viene passata come parametro
     * @param string $email
     * @return mixed
     */
    public static function loadIDbyEmail(string $email)
    {
        $db = FDataBase::getInstance();
        if(strpos($email, '@info.it'))
            return $db->getSomethingby(FAgenteImmobiliare::class, "id", "mail", $email)[0]["id"];
        else
            return $db-> getSomethingby(FCliente::class, "id", "mail", $email)[0]["id"];


    }

    public static function eliminaUtente(MUtente $utente) :bool
    {
        $db = FDataBase::getInstance();
        if($utente instanceof MCliente)
        {
            $num =count(FUtente::visualizzaAppUtente($utente->getId())->getListAppuntamenti());
            if($num !=0)
                $db->deleteDB(FAppuntamento::class, 'id_cliente', $utente->getId());
            $deleted = $db->deleteDB(FCliente::class, 'id', $utente->getId());

            return $deleted;
        }
    }

    /**
     * Ritorna tutti gli utenti il cui tipo(CLIENTE/AGENTE) viene passato come parametro
     * @param string $type
     * @return array
     */
    public static function getUtenti(string $type)
    {
        $db = FDataBase::getInstance();
        if($type === "CLIENTE")
            $db_result = $db->loadAll(FCliente::class);
        elseif($type==="AGENTE") $db_result = $db->loadAll(FAgenteImmobiliare::class);
        $utenti = array();
        foreach ($db_result as &$item)
        {
            if($type === "CLIENTE")
                $utente = new MCliente();
            elseif($type==="AGENTE") $utente = new MAgenteImmobiliare();
            self::setAttributiUtente($utente, $item);
            $utenti[] = $utente;
        }
        return $utenti;
    }

}