<?php 
/**
 * This is a basic implementation of a basic dynamic array
 * data structure in php demonstrating it's constant
 * indexing time and linear insert/deletion 
 */
class arrayElement {
    //Data that the element holds
    public $data;
    public function __construct($data=NULL)
    {
        $this->data = $data;
    }
    //Updates the data
    public function setData($data)
    {
        $this->data = $data;
    }
}   
class basicArray {
    //size of array
    public $size;
    protected $from;
    protected $to;
    //when constructed the array has an initial element at position 0
    public function __construct($data=NULL)
    {
        $this->size = 0;
        $this->newElement(0);
        $this->{'0'}->data = $data;
    }
    //New Element functions that takes array position of element
    //to be added and add any skipped elements
    protected function newElement($pos)
    {
        if(($pos-1)>$this->size)
        {
            for($i=$this->size; $i<$pos; $i++)
            {
                $this->$i = new arrayElement();
                $this->size++;
            }
        }
        $this->$pos = new arrayElement();
        $this->size++;
    }
    //And add element funtion that inserts element at end of 
    //array in constant time O(1)
    public function addElement($data)
    {
        $this->newElement($this->size);
        $this->updateElement($this->size-1, $data);
        
    }
    //Constant speed lookup when given index of the element O(1)
    public function element($pos)
    {
        return $this->$pos->data;
    }
    //Updates an element at constant O(1) speed given position and data to update.
    public function updateElement($pos, $data)
    {
        if(is_null($this->$pos))
        {
            throw new exception('the index you entered is out of range');
        }
        else
        {
            $this->$pos->setData($data);
        }
    }
    //Returns the size of the array
    public function size()
    {
        return $this->size;
    }
    //An insert function that inserts new elements into the array at given position at 
    //on average N/2 = O(n) speed and with best case of constant speed (at end)
    public function insertElement($pos, $data)
    {
        if(!isset($this->$pos))
        {
           $this->newElement($pos);
           $this->updateElement($pos, $data);
        }
        else
        {
            $this->addElement('');
            for($i=(($this->size)-1); $i>$pos; $i--)
            {
                $from = $i-1;
                $to = $i; 
               $this->$to->setData($this->$from->data); 
            }
            $this->updateElement($pos, $data);
        }
    }
    //An insert function that inserts new elements into the array at given position at 
    //on average N/2 = O(n) speed and with best case of constant speed (at end)
    public function deleteElement($pos)
    {
        if(!isset($this->$pos))
        {
            throw new exception('The position of the element is out of range');
        }
        else
        {
            for($i=$pos; $i<(($this->size)-1); $i++)
            {
                $from = $i+1;
                $to = $i; 
               $this->$to->setData($this->$from->data); 
            }
            $this->size--;

        }
    }
    //display elements of the array in string form
    public function __tostring()
    {
        $array = '';
        for($i=0;$i<$this->size;$i++)
        {
            $array = $array.' '.$this->$i->data;
        }
        return $array;
    }
}
?>
