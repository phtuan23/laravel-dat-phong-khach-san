<?php 

    namespace App\Helper;

    class Booking{
        
        public $bookings = [];
        public $total_price = 0;
        public $sale;
        public function __construct(){
            $this->bookings = session('booking') ? session('booking') : [];
            $this->total_price = $this->totalPrice();
            $this->sale = session('sale') ? session('sale') : 0;
        }

        public function update_sale($value)
        {
            $this->sale = $value;
            session(['sale' => $this->sale]);
        }


        public function add($room,$date_in,$date_out){
            $start = strtotime($date_in);
            $end = strtotime($date_out);
            $date = abs($end-$start);
            $item = [
                'id' => $room->id,
                'name' => $room->name,
                'category' => $room->category->name,
                'max_people' => $room->category->max_people,
                'size' => $room->category->size,
                'description' => $room->category->description,
                'price' => $room->price,
                'image' => $room->image,
                'date_in' => $date_in,
                'date_out' => $date_out,
                'total_day' => floor($date/(60*60*24)),
                'service' => []
            ];
            if(!isset($this->bookings[$room->id])){
                $this->bookings[$room->id] = $item;
            }
            session(['booking' => $this->bookings]);
        }

        public function update($id,$_services)
        {
            foreach($_services as $serv){
                $_srv = [
                    'id' => $serv->id,
                    'name' => $serv->name,
                    'image' => $serv->image,
                    'price' => $serv->price,
                    'total_price' => $serv->price*$this->bookings[$id]['total_day']
                ];
                if(!isset($this->bookings[$id]['service'][$serv->id])){
                    $this->bookings[$id]['service'][$serv->id] = $_srv;
                }
            }
            session(['booking' => $this->bookings]);
        }

        public function delete_service($id_bk,$id_service)
        {
            if(isset($this->bookings[$id_bk]['service'][$id_service])){
                unset($this->bookings[$id_bk]['service'][$id_service]);
            }
            session(['booking' => $this->bookings]);
        }

        public function delete($id)
        {
            if(isset($this->bookings[$id])){
                unset($this->bookings[$id]);
            }
            session(['booking' => $this->bookings]);
        }

        public function clear(){
            session(['booking' => []]);
            session(['sale' => 0]);
        }

        public function totalPrice()
        {
            $price = 0;
            foreach($this->bookings as $bk){
                $price += $bk['price']*$bk['total_day'];
                foreach($bk['service'] as $bk_sv){
                    $price+= $bk_sv['price']*$bk['total_day'];
                }
            }
            return $price;
        }
    }

?>