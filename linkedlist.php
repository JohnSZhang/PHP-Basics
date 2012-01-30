<?php 
/**
 * A PHP Single Linked List Example
 */

class linknode{

    //Data that the node holds
    public $data;
    //Reference to next node
    public $next;  
    public function  __construct($data)
    {
        //Construct the Node so the next reference is null
        $this->data = $data;
        $this->next = NULL;
    }

    //Function to get the next node in list
    public function getNext()
    {
        return $this->next;
    }

}

class linkedList{
    //Create the first node in the list
    public $firstnode;
    //Create a node count
    private $nodecount;
    public function __construct()
    {
        $firstnode = NULL;
        $nodecount = 0;
    }
    //Returns length of list
    public function length()
    {
        return $this->nodecount;
    }
    //Insert a node at beginning of list done in O(1) constant time
    public function insertFirst($data)
    {
        $newnode = new linkNode($data);
        $newnode->next = $this->firstnode;
        $this->firstnode = &$newnode;

        $this->nodecount++;
    }
    //Remove the first node done in O(1) constant time
    public function removeFirst()
    {
        if($this->firstnode !== NULL)
            
        {
            $nextnode = $this->firstnode->next;
            $this->firstnode = &$nextnode;
            $this->nodecount--;
        }

    }
    //A find node function in O(n) linear time
    //Returns the first node that matches, or null
    public function findNode($needle)
    {
        $currentnode = $this->firstnode;
        for($i=1;$i<$this->nodecount;$i++)
        {
            if($currentnode->data == $needle)
            {
                return $currentnode;
                exit;
            }
            $currentnode = $currentnode->next;
        }
        if ($currentnode = NULL)
        {
            return NULL;
        }

    }
    //A get node function in O(n) linear time
    //Each additional search is done in average n/2 = n times
    public function getNode($pos)
    {
        if ($pos>$this->nodecount)
        {
            throw new exception('you are trying to insert after more than 
                    the last item of the linked list!!');
        }
        else
        {
            $currentnode = $this->firstnode;
            for ($i=1;$i<$pos;$i++)
            {
                $currentnode = $currentnode->next;
            }
        }
        return $currentnode;
    }
    //An insert after node # pos function done in O(n) linear time 
    //Average is actually n/2 which = n
        public function insertAfter($pos, $data)
    {
        $previousnode = $this->getNode($pos);
        $insertnode = new linkNode($data);
        $insertnode->next = $previousnode->next;
        $previousnode->next = $insertnode;
        $this->nodecount++;
            
    }
    //A delete after node # pos function that's also O(n) like insertAfter
    public function deleteAfter($pos)
    {
        $previousnode = $this->getNode($pos);
        if(isset($previousnode->next->next))
        {
        $nextnode = $previousnode->next->next;
        }
        else
        {
        $nextnode = NULL;
        }
        $previousnode->next = $nextnode;
        $this->nodecount--;
    }
    
    //Print the object;
    public function __toString()
    {
        $string = '';
        $currentnode = $this->firstnode;
        for($i=0;$i<$this->nodecount;$i++)
        {
            $string = $string.$currentnode->data;
            if($currentnode->next !== NULL)
            {
            $currentnode = $currentnode->next;
            }
        }
        return $string;
    }


}
$testlist = new linkedList;
$testlist->insertFirst(', and not to yield');
$testlist->insertFirst(', to find');
$testlist->insertFirst(', to seek');
$testlist->insertFirst('To strive');
$testlist->insertAfter(2, ', to do something else');
$testlist->deleteAfter(2);
echo $testlist;
echo is_null($testlist->findNode('that which cannot be found'));
?>
