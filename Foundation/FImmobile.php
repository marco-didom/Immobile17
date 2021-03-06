<?php

/**
 * Class FImmobile
 * Si occupa delle iterazioni con FDataBase per quanto riguarda gli oggetti MImmobile
 * @author Della Pelle - Di Domenica - Foderà
 * @package foundation
 */
class FImmobile extends FObject
{
    private static string $table="immobile";
    private static string $values="(:id,:nome,:citta,:indirizzo,:tipologia,:dimensione,
                                    :descrizione,:tipo_annuncio,:prezzo,:attivo)";
    private static string $idString = "IM";

    /**
     * @param PDOStatement $stmt
     * @param oggetto $obj
     * @param string $newId
     */
    public static function bind(PDOStatement $stmt, $obj, string $newId): void
    {
        $stmt->bindValue(':id',$newId,PDO::PARAM_STR);
        $stmt->bindValue(':nome',$obj->getNome(),PDO::PARAM_STR);
        $stmt->bindValue(':citta',$obj->getComune(),PDO::PARAM_STR);
        $stmt->bindValue(':indirizzo',$obj->getIndirizzo(),PDO::PARAM_STR);
        $stmt->bindValue(':tipologia',$obj->getTipologia(),PDO::PARAM_STR);
        $stmt->bindValue(':dimensione',$obj->getGrandezza(),PDO::PARAM_STR);
        $stmt->bindValue(':descrizione',$obj->getDescrizione(),PDO::PARAM_STR);
        $stmt->bindValue(':tipo_annuncio',$obj->getTipoAnnuncio(),PDO::PARAM_STR);
        $stmt->bindValue(':prezzo',$obj->getPrezzo(),PDO::PARAM_STR);
        $stmt->bindValue(':attivo',$obj->isAttivo(),PDO::PARAM_STR);

    }

    /**
     * @return string
     */
    public static function getTable(): string
    {
        return self::$table;
    }

    /**
     * @return string
     */
    public static function getValues(): string
    {
        return self::$values;
    }

    /**
     * @return string
     */
    public static function getID():string
    {
        return self::$idString;
    }


    /**
     * Aggiunge l'MImmobile passato come parametro al DB
     * @param MImmobile $immobile
     * @return bool esito dell'operazione
     */
    public static function addImmobile (MImmobile $immobile) :bool
    {
        $db= FDataBase::getInstance();
        return $db->storeDb(self::class,$immobile);
    }

    /**
     * Ritorna l'Immobile con l'Id passato come paramentro se esiste, null altrimenti
     * @param string $id
     * @return MImmobile|null
     */
    public static function getImmobile(string $id)
    {
        $db= FDataBase::getInstance();
        if($db->existDB(self::class,"id",$id)) {
            $db_result = $db->loadDB(self::class, "id", $id);
            if($db_result != null)
                return self::unBindImmobile($db_result[0]);
            else return null;
        }
        else return null;

    }

    /**
     * Ritorna un MImmobile dall'array di attributi $db_result
     * @param array $db_result
     * @return MImmobile
     */
    public static function unBindImmobile(array $db_result) :MImmobile
    {
        $immobile= new MImmobile();
        $immobile->setId($db_result["id"]);
        $immobile->setNome($db_result["nome"]);
        $immobile->setComune($db_result["citta"]);
        $immobile->setIndirizzo($db_result["indirizzo"]);
        $immobile->setTipologia($db_result["tipologia"]);
        $immobile->setDescrizione($db_result["descrizione"]);
        $immobile->setGrandezza($db_result["dimensione"]);
        $immobile->setTipoAnnuncio($db_result["tipo_annuncio"]);
        $immobile->setPrezzo($db_result["prezzo"]);
        $immobile->setAttivo($db_result["attivo"]);
        if (FMedia::getMedia($immobile->getId())!=null && count(FMedia::getMedia($immobile->getId()))>0) {
            $immobile->setImmagini(FMedia::getMedia($immobile->getId()));
            foreach ($immobile->getImmagini() as &$immagine)
                $immagine->setImmobile($immobile);
        }
        return $immobile;
    }

    /**
     * Ritorna tutti gli immobili presenti nel DB
     * @return array
     */
    public static function getImmobili()
    {
        $db=FDataBase::getInstance();
        $db_result = $db->loadAll(self::class);
        $immobili = array();
        foreach ($db_result as &$item)
            $immobili[] = self::unBindImmobile($item);
        return $immobili;
    }

    /**
     * Disabilita l'Immobile passato come parametro
     * @param MImmobile $immobile
     * @return bool esito dell'operazione
     */
    public static function disabilita(MImmobile $immobile) :bool
    {
        $db=FDataBase::getInstance();
        return $db->updateDB(self::class,"attivo",false,"id",$immobile->getId());
    }

    /**
     * Confronta l'Immobile passato come parametro con quello presente nel DB
     * Aggiorna il DB con i campi aggiornati del nuovo Immobile
     * @param MImmobile $immobile
     * @return bool esito dell'operazione
     */
    public static function modificaImmobile(MImmobile $immobile) :bool
    {
        $db = FDataBase::getInstance();
        if($db->existDB(self::class, "id", $immobile->getId())) {

            $oldImmobile = self::getImmobile($immobile->getId());
            $mods = array();

            if ($oldImmobile->getIndirizzo() != $immobile->getIndirizzo())
                $mods["indirizzo"] = $immobile->getIndirizzo();
            if ($oldImmobile->getNome() != $immobile->getNome())
                $mods["nome"] = $immobile->getNome();
            if ($oldImmobile->getComune() != $immobile->getComune())
                $mods["citta"] = $immobile->getComune();
            if ($oldImmobile->getTipologia() != $immobile->getTipologia())
                $mods["tipologia"] = $immobile->getTipologia();
            if ($oldImmobile->getTipoAnnuncio() != $immobile->getTipoAnnuncio())
                $mods["tipo_annuncio"] = $immobile->getTipoAnnuncio();
            if ($oldImmobile->getGrandezza() != $immobile->getGrandezza())
                $mods["dimensione"] = $immobile->getGrandezza();
            if ($oldImmobile->getPrezzo() != $immobile->getPrezzo())
                $mods["prezzo"] = $immobile->getPrezzo();
            if ($oldImmobile->getDescrizione() != $immobile->getDescrizione())
                $mods["descrizione"] = $immobile->getDescrizione();
            if ($oldImmobile->isAttivo() != $immobile->isAttivo())
            {
                if(!$immobile->isAttivo())
                    $mods['attivo'] = 0;
                else $mods['attivo'] = 1;
            }

            foreach (array_keys($mods) as $key)
            {
                $toReturn = $db->updateDB(self::class, $key, $mods[$key], "id", $immobile->getId());
                if(!$toReturn)
                    return false;
            }
            return true;

        }
        else return false;

    }

    /**
     * Ritorna l'Immobile in questione con la lista appuntamenti contenente gli appuntamenti compresi fra le due date
     * @param string $id
     * @param MData $inizio
     * @param MData $fine
     * @return MImmobile|null
     */
    public static function getAppImmobileInBetween(string $id, MData $inizio, MData $fine) :?MImmobile
    {
        $immobile = self::getImmobile($id);
        $immobile->setListAppuntamenti(FAppuntamento::getAppInBetween($id,$inizio,$fine));
        return $immobile;
    }

    /**
     * Ritorna l'immobile con l'id passato come parametro con la lista appuntamenti completa
     * @param string $id
     * @return MImmobile
     */
    public static function getAppImmobile(string $id) :MImmobile
    {
        $immobile = self::getImmobile($id);
        $immobile->setListAppuntamenti(FAppuntamento::visualizzaAppOggetto($id));
        return $immobile;
    }

    /**
     * Ritorna un array contente i 3 immobili più costosi
     * @return array
     */
    public static function getImmobiliHomepage()
    {
        $db=FDataBase::getInstance();
        $db_result = $db->loadOrderBy(self::class, 'id', 'prezzo');
        $immobili = array();
        foreach ($db_result as &$item)
            $immobili[] = self::unBindImmobile($item);

        return array_slice($immobili,0,3);
    }

    /**
     * Ritorna un array contenente gli immobili per i quali il campo field è type
     * @param $field
     * @param $type
     * @return array
     */
    public static function getByType($field ,$type) :array
    {
        $db=FDataBase::getInstance();
        $db_result = $db->getSomethingby(self::class, "*", $field , $type);
        $immobile = array();
        foreach ($db_result as &$item)
            $immobile[] = self::unBindImmobile($item);
        return $immobile;
    }

    /**
     * Ritorna un array contenente gli immobili in cui il campo field è compreso fra min e max
     * @param $field
     * @param $min
     * @param $max
     * @return array
     */
    public static function getByPriceOrSize($field, $min, $max) :array
    {
        $db = FDataBase::getInstance();
        $db_result = $db-> loadValuesIncluded(self::class, $field, $min, $max);
        $immobile = [];
        foreach ($db_result as &$item)
            $immobile[] = self::unBindImmobile($item);
        return $immobile;
    }

    /**
     * Ritorna un array contenente gli immobili nel cui nome è contenuta la keyword
     * @param $keyword
     * @return array
     */
    public static function getByKeyword (string $keyword) :array
    {
        $db = FDataBase::getInstance();
        $db_result = $db-> loadByKeyword(self::class, 'nome', $keyword);
        $immobile = [];
        foreach ($db_result as &$item)
            $immobile[] = self::unBindImmobile($item);
        return $immobile;
    }

    /**
     * Ritorna un array di iimobili che rispettano i parametri contenuti in parameters
     * parameters è un array che rispetta le norme descritte per i parametri della ricerca immobili
     * @param array $parameters
     * @return array
     */
    public static function getImmobiliByParameters(array $parameters)
    {
        $db = FDataBase::getInstance();
        $db_result = $db->loadIntersect(self::class, $parameters);
        $immobile = [];
        foreach ($db_result as &$item)
            $immobile[] = self::unBindImmobile($item);
        return $immobile;
    }

    /**
     * Elimina dal DB l'immobile con l'id id
     * @param string $id
     * @return bool
     */
    public static function eliminaImmobile(string $id) :bool
    {
        $db = FDataBase::getInstance();
        return $db->deleteDB(self::class, 'id', $id);
    }
}