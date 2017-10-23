<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Properties;
use App\PropertyDetail;
class PropertiesController extends Controller
{

    protected $rets_login_url;
    protected $rets_username;
    protected $rets_password;
    protected $rets;
     protected $connect;


    public function __construct(){
        $this->rets_login_url = "http://data.crea.ca/Login.svc/Login";
        // $this->rets_username = "Vbx1Vzsefyrt2dnj4sn0wDbd"; // redacted
        // $this->rets_password = "jV5MgK8fEQkWW4yuDgiXT3cr"; //
        $this->rets_username = "mDuJJWo7fZ0xwTrqyaMxm4ZJ"; // redacted
        $this->rets_password = "Pa5ecSNJbvsQMSkdcnbTRJaf"; //

        $this->rets = new \phRETS;
        $this->connect = $this->rets->Connect($this->rets_login_url, $this->rets_username, $this->rets_password);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

       
        if ($this->connect) {
            echo "Connected";    
        }
        else {
                echo "  + Not connected:<br>\n";
                print_r($rets->Error());
                exit;
        }
        $property_classes = array("Property");
        foreach ($property_classes as $class) {
            $query = "ID=*";
            $offset = 1;
            $limit = 'None';
            $search = $this->rets->SearchQuery("Property", $class, $query, array('Limit' => $limit, 'Offset' => $offset, 'Format' => 'STANDARD-XML', 'Count' => 1));
            echo "<pre>";
            print_r($search);
            exit;
            foreach ($search['Properties'] as $key => $value) {
                $id = $value['@attributes']['ID'];
                $date = $value['@attributes']['LastUpdated'];
                $existed_property = Properties::where('pid',$id)->first();
                if(!$existed_property){
                    $property = new Properties;
                    $property->pid = $id;
                    $property->last_update = $date;
                    $property->save();
                }
            }
            
        }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function detail(){
        $properties = Properties::all();
        foreach ($properties as $key => $value) {
            $p_id = $value['pid'];       
            $existed_property_detail = PropertyDetail::where('property_id',$p_id)->first();
            if(!$existed_property_detail){
                $query = "ID=".$p_id;
                $offset = 1;
                $limit = 'None';
                $properties = $this->rets->SearchQuery("Property", "Property", $query, array('Limit' => $limit, 'Offset' => $offset, 'Format' => 'STANDARD-XML', 'Count' => 1));
                $allData = $properties['Properties'][0];
                // echo "<pre>";
                // print_r($allData);
                // exit;
                $property = new PropertyDetail; 
                $property->property_id = $p_id;
                if(isset($allData['Building']['BathroomTotal'])){
                    $property->bathrooms = $allData['Building']['BathroomTotal'];
                }else  $property->bathrooms=0;
                
                if(isset($allData['Building']['BedroomsTotal'])){
                    $property->bedrooms = $allData['Building']['BedroomsTotal'];
                }else  $property->bedrooms = 0;
                
                if(isset($allData['Building']['BedroomsAboveGround'])){
                    $property->bedrooms_above_ground = $allData['Building']['BedroomsAboveGround'];
                }else $property->bedrooms_above_ground=0;
                
                if(isset($allData['Building']['BedroomsBelowGround'])){
                    $property->bedrooms_below_ground = $allData['Building']['BedroomsBelowGround'];
                }else  $property->bedrooms_below_ground = 0;
                
                if(isset($allData['Building']['Amenities'])){
                    $property->amenities = $allData['Building']['Amenities'];
                }else  $property->amenities="";
                
                if(isset($allData['Building']['cooling_type'])){
                    $property->cooling_type = $allData['Building']['CoolingType'];
                }else $property->cooling_type  = "";

                if(isset($allData['Building']['cooling_type'])){
                    $property->exterior_finish = $allData['Building']['ExteriorFinish'];
                }else  $property->exterior_finish ="";

                if(isset($allData['Building']['cooling_type'])){
                    $property->fireplace_present = $allData['Building']['FireplacePresent'];
                }else  $property->fireplace_present="";

                if(isset($allData['Building']['cooling_type'])){
                    $property->heating_fuel = $allData['Building']['HeatingFuel'];
                }else  $property->heating_fuel="";

                if(isset($allData['Building']['cooling_type'])){
                    $property->Heating_type = $allData['Building']['HeatingType'];
                }else  $property->Heating_type="";

                if(isset($allData['Building']['cooling_type'])){
                    $property->type = $allData['Building']['Type'];
                }else $property->type="";

                if(isset($allData['Address']['StreetAddress'])){
                    $property->street_address = $allData['Address']['StreetAddress'];
                }else  $property->street_address = "";

                if(isset($allData['Address']['AddressLine1'])){
                    $property->address_line1 = $allData['Address']['AddressLine1'];
                }else  $property->address_line1 = "";

                if(isset($allData['Address']['StreetNumber'])){
                    $property->street_number = $allData['Address']['StreetNumber'];
                }else  $property->street_number = "";

                if(isset($allData['Address']['StreetName'])){
                    $property->street_name = $allData['Address']['StreetName'];
                }else  $property->street_name = "";

                if(isset($allData['Address']['StreetSuffix'])){
                    $property->street_suffix = $allData['Address']['StreetSuffix'];
                }else $property->street_suffix = "";   

                if(isset($allData['Address']['UnitNumber'])){
                    $property->unit_number = $allData['Address']['UnitNumber'];
                }else  $property->unit_number = "";

                if(isset($allData['Address']['City'])){
                    $property->city = $allData['Address']['City'];
                }else $property->city = "";

                if(isset($allData['Address']['Province'])){                
                    $property->province = $allData['Address']['Province'];
                }else  $property->province = "";

                if(isset($allData['Address']['PostalCode'])){
                    $property->postal_code = $allData['Address']['PostalCode'];
                }else  $property->postal_code = "";

                if(isset($allData['Address']['Country'])){
                    $property->country = $allData['Address']['Country'];
                }else $property->country = "";
                

                if(isset($allData['Address']['CommunityName'])){
                    $property->community_name = $allData['Address']['CommunityName'];
                }else  $property->community_name = "";

                if(isset($allData['Features'])){
                    $property->features = $allData['Features'];
                }else  $property->features = "";

                if(isset($allData['ListingContractDate'])){
                    $property->listing_contract_date = $allData['ListingContractDate'];
                }else  $property->listing_contract_date = "";

                if(isset($allData['MaintenanceFee'])){
                    $property->maintenance_fee = $allData['MaintenanceFee'];
                }else  $property->maintenance_fee = "";
                
                if(isset($allData['MaintenanceFeePaymentUnit'])){
                    $property->maintenance_fee_payment_unit = $allData['MaintenanceFeePaymentUnit'];
                }else  $property->maintenance_fee_payment_unit = "";
                
                if(isset($allData['ManagementCompany'])){
                    $property->management_company = $allData['ManagementCompany'];
                }else $property->management_company ="";

                if(isset($allData['OwnershipType'])){
                    $property->ownership_type = $allData['OwnershipType'];
                }else  $property->ownership_type = "";

                if(isset($allData['ParkingSpaceTotal'])){
                    $property->parking_space_total = $allData['ParkingSpaceTotal'];
                }else $property->parking_space_total = "";
                
                if(isset($allData['Price'])){
                    $property->price = $allData['Price'];
                }else $property->price = "";

                if(isset($allData['PropertyType'])){
                    $property->property_type = $allData['PropertyType'];
                }else  $property->property_type = "";

                if(isset($allData['PublicRemarks'])){
                    $property->public_remarks = $allData['PublicRemarks'];
                }else  $property->public_remarks = "";

                if(isset($allData['TransactionType'])){
                    $property->transaction_type = $allData['TransactionType'];
                }else  $property->transaction_type = "";

                if(isset($allData['MoreInformationLink'])){
                    $property->more_information_link = $allData['MoreInformationLink'];
                }else  $property->more_information_link = "";

                $property->save();
            }    
        }
        echo "Process has completed";
    }
}
