<?php 
/**
 * This is a basic implementation of a dynamic array
 * with linked lists colission and md5 hash, dynamic 
 * resize base case of 16 buckets and resizes when k/n =.7
 */
class hashTable {
    protected $resizetrigger = 0.7;
    public $hashsize;
    public $hasharray;
    function __construct()
    {
        $this->hasharray = new hashArray(16);
        $this->hashsize = 16;
    }
    public function push($key, $value) 
    {
        $hash = $this->hash($key);
        $this->hasharray->updateValue($hash, $key, $value);
        $this->resize();
    }
    public function get($key)
    {
        $hash = $this->hash($key);
        return $this->hasharray->getValue($hash, $key);
    }
    public function remove($key)
    {
        $hash = $this->hash($key);
        $this->hasharray->removeValue($hash, $key);
    }
    public function resize()
    {
        $fill = $this->hasharray->fill;
        $size = $this->hasharray->size;
        if(($fill/$size)>.7)
        {
            $hashsize = $this->hashsize;
            $newsize = $hashsize * $hashsize;
            $this->hashsize = $newsize;
            $newarray = new hashArray($newsize);
            for($i=0;$i<$hashsize;$i++)
            {
                $currentnode=$this->hasharray->$i->firstnode;
                while($currentnode)
                {
                    $hash = $this->hash($currentnode->key);
                    $newarray->updateValue($hash, 
                            $currentnode->key, $currentnode->data);
                    $currentnode = $currentnode->next;
                }

            }
            $this->hasharray = $newarray;
        }
    }
    public function hash($key)
    {
        $result = md5($key);
        return hexdec(substr($result,1,log($this->hashsize,16))); 
    }

}
class hashArray{
    public $fill;   
    public $size;
    public function __construct($size)
    {
        for($i=0;$i<$size;$i++)
        {
            $this->$i = new hashLinkedList();
        }
        $this->size=$size;
        $this->fill=0;

    }
    function updateValue($hashkey, $key, $value)
    {
        if(is_null($this->$hashkey->searchNode($key)))
        {
            $this->fill++;
        }
        $this->$hashkey->addNode($key, $value);
    }
    public function removeValue($hashkey, $key)
    {
        $this->$hashkey->removeNode($value);
        $this->fill--;

    }
    public function getValue($hashkey, $key)
    {
        return $this->$hashkey->returnData($key);
    }
}
class hashLinkNode {
    public $data;
    public $next;  
    public $key;
    public function __construct($key=NULL, $data=NULL)
    {
        $this->key = $key;
        $this->data = $data;
        $this->next = NULL;
    }
    public function getNext()
    {
        return $this->next;
    }

    function __tostring()
    {
        $result = $this->key.' '.$this->data;
        return $result;
    }
}
class hashLinkedList {
    public $firstnode;
    public $count;
    public function __construct($key=NULL, $data=NULL)
    {
        $this->firstnode = new hashLinkNode($key, $data);
        $this->count = 1;
    }
    public function addNode($key, $data)
    {
        $exist = $this->searchNode($key);
        if(!$exist==NULL)
        {
            $exist->data = $data;
        }
        else if($exist==NULL)
        {
            $newnode = new hashLinkNode($key, $data);
            $newnode->next = $this->firstnode;
            $this->firstnode = $newnode;
            $this->count++;
        }
    }
    public function searchNode($key)
    {
        $result = NULL;
        $currentnode = $this->firstnode;
        while($currentnode)
        {
            if($currentnode->key == $key)
            {
                $result = $currentnode;
            }
            $currentnode = $currentnode->next;
        }
        return $result;
    }
    public function removeNode($key)
    {
        $exist = $this->searchNode($key);
        if($exist==NULL)
        {
            throw new exception('the key you entered is not matched');
        }
        else
        {
            $currentnode = $this->firstnode;
            while($currentnode)
            {
                if($currentnode==$this->firstnode&&$currentnode->key==$key)
                {
                    if($currentnode->next==NULL)
                    {
                        $this->firstnode->data=NULL;
                        $this->firstnode->key=NULL;
                        $this->count--;
                        break;
                    }
                    else
                    {
                        $this->firstnode=$currentnode->next;
                        $this->count--;
                        break;
                    }
                }
                $nextnode = $currentnode->next;
                if($nextnode&&$nextnode->key==$key 
                        && $nextnode->next==NULL)
                {
                    $currentnode->next = NULL;
                    $this->count--;
                }
                else if($nextnode &&$nextnode->key==$key 
                        && $nextnode->next!==NULL)
                {
                    $currentnode->next = $nextnode->next;
                    $this->count--;
                }
                $currentnode=$currentnode->next;
            }
        }
    }
    public function returnData($key)
    {
        return $this->searchNode($key)->data;
    }
    function __tostring()
    {
        $result = '';
        $currentnode = $this->firstnode;
        while($currentnode)
        {
            $result = $result.$currentnode->key.' '.$currentnode->data.' ';
            if($currentnode->next)
            {
                $currentnode = $currentnode->next;
            }
            else
            {
                break;
            }
        }
        return $result;
    }
}
$testhash = new hashLinkedList('zebra', 'run');
$testhash->addNode('lion', 'hunt');
$testhash->addNode('eagle', 'beak');
$testhash->addNode('fish', 'swim');
$testhash->addNode('humans','kill');
$testhash->removeNode('zebra');
$hashtable = new hashTable;
$hashtable->push('1', 'uno');
$hashtable->push('15', 'now i have changed');
$hashtable->push('2', 'now i have changed');
$hashtable->push('3', 'now i have changed');
$hashtable->push('4', 'now i have changed');
$hashtable->push('5', 'now i have changed');
$hashtable->push('6', 'now i have changed');
$hashtable->push('7', 'now i have changed');
$hashtable->push('8', 'now i have changed');
$hashtable->push('9', 'now i have changed');
$hashtable->push('10', 'now i have changed');
$hashtable->push('11', 'now i have changed');
$hashtable->push('12', 'now i have changed');
$hashtable->push('13', 'now i have changed');
$hashtable->push('14', 'now i have changed');
echo $hashtable->hashsize;
echo $hashtable->get('14');
