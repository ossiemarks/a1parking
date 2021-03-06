<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TicketRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TicketCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TicketCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Ticket::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/ticket');
        CRUD::setEntityNameStrings('ticket', 'tickets');


    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

         $this->crud->addColumn([
           'name' => 'officer_id', // The db column name
           'label' => "OID", // Table column heading
           'type' => 'number'
         ]);

         $this->crud->addColumn([
           'name' => 'created_at', // The db column name
           'label' => "Date of Issue", // Table column heading
           'type' => 'date'
         ]);

         $this->crud->addColumn([
           'name' => 'dvla_req_sent', // The db column name
           'label' => "DVLA Request Sent", // Table column heading
           'type' => 'boolean'
         ]);

         $this->crud->addColumn([
           'name' => 'last_name', // The db column name
           'label' => "Driver Details", // Table column heading
           'type' => 'text'
         ]);

         $this->crud->addColumn([
           'name' => 'notice_sent', // The db column name
           'label' => "Notice Sent", // Table column heading
           'type' => 'boolean'
         ]);

         $this->crud->addColumn([
           'name' => 'reminder_sent', // The db column name
           'label' => "Reminder Sent", // Table column heading
           'type' => 'boolean'
         ]);

         $this->crud->addColumn([
           'name' => 'payment_made_date', // The db column name
           'label' => "Payment Made", // Table column heading
           'type' => 'date'
         ]);


         $this->crud->addFilter([
           'type'  => 'simple',
           'name'  => 'DVLA',
           'label' => 'DVLA'
         ],
         false, // the simple filter has no values, just the "Draft" label specified above
         function() { // if the filter is active (the GET parameter "draft" exits)
           $this->crud->addClause('where', 'dvla_req_sent', '0');
           // we've added a clause to the CRUD so that only elements with draft=1 are shown in the table
           // an alternative syntax to this would have been
           // $this->crud->query = $this->crud->query->where('draft', '1');
           // another alternative syntax, in case you had a scopeDraft() on your model:
           // $this->crud->addClause('draft');
         });

         $this->crud->addFilter([
           'type'  => 'simple',
           'name'  => 'drivers',
           'label' => 'Driver Details'
         ],
         false,
         function() {
           $this->crud->addClause('whereNull', 'last_name');
         });

         $this->crud->addFilter([
           'type'  => 'simple',
           'name'  => 'notices',
           'label' => 'Notices'
         ],
         false,
         function() {
           $this->crud->addClause('where', 'notice_sent', '0');
         });

         $this->crud->addFilter([
           'type'  => 'simple',
           'name'  => 'reminders',
           'label' => 'Reminders'
         ],
         false,
         function() {
           $this->crud->addClause('where', 'reminder_sent', '0');
         });

         $this->crud->addFilter([
           'type'  => 'simple',
           'name'  => 'payments',
           'label' => 'Payments'
         ],
         false,
         function() {
           $this->crud->addClause('whereNull', 'payment_made_date');
         });

         $this->crud->denyAccess('delete');
         $this->crud->denyAccess('show');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TicketRequest::class);

        // CRUD::setFromDb(); // fields

        $this->crud->addField([
          'name' => 'officer_id', // The db column name
          'label' => "OID", // Table column heading
          'type' => 'number'
        ]);

        $this->crud->addField([
          'name' => 'created_at', // The db column name
          'label' => "Date of Issue", // Table column heading
          'type' => 'date'
        ]);

        $this->crud->addField([
          'name' => 'reg_no', // The db column name
          'label' => "Registration Number", // Table column heading
          'type' => 'text'
        ]);

        $this->crud->addField([
          'name' => 'dvla_req_sent', // The db column name
          'label' => "DVLA Request Sent", // Table column heading
          'type' => 'boolean'
        ]);

        $this->crud->addField([
          'name' => 'first_name', // The db column name
          'label' => "First Name", // Table column heading
          'type' => 'text'
        ]);

        $this->crud->addField([
          'name' => 'last_name', // The db column name
          'label' => "Last Name", // Table column heading
          'type' => 'text'
        ]);

        $this->crud->addField([
          'name' => 'address1', // The db column name
          'label' => "Address 1", // Table column heading
          'type' => 'text'
        ]);

        $this->crud->addField([
          'name' => 'address2', // The db column name
          'label' => "Address 2", // Table column heading
          'type' => 'text'
        ]);

        $this->crud->addField([
          'name' => 'address3', // The db column name
          'label' => "Address 3", // Table column heading
          'type' => 'text'
        ]);

        $this->crud->addField([
          'name' => 'town', // The db column name
          'label' => "Town", // Table column heading
          'type' => 'text'
        ]);

        $this->crud->addField([
          'name' => 'postcode', // The db column name
          'label' => "Postcode", // Table column heading
          'type' => 'text'
        ]);




        $this->crud->addField([
          'name' => 'notice_sent', // The db column name
          'label' => "Notice Sent", // Table column heading
          'type' => 'boolean'
        ]);

        $this->crud->addField([
          'name' => 'reminder_sent', // The db column name
          'label' => "Reminder Sent", // Table column heading
          'type' => 'boolean'
        ]);

        $this->crud->addField([
          'name' => 'payment_made_date', // The db column name
          'label' => "Payment Date", // Table column heading
          'type' => 'date'
        ]);

        $this->crud->addField([
          'name' => 'payment_made_amt', // The db column name
          'label' => "Payment Amount", // Table column heading
          'type' => 'number'
        ]);

        $this->crud->addField([
          'name' => 'gps_lat', // The db column name
          'label' => "GPS Lat", // Table column heading
          'type' => 'number'
        ]);

        $this->crud->addField([
          'name' => 'gps_lon', // The db column name
          'label' => "GPS Lon", // Table column heading
          'type' => 'number'
        ]);



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */

         // base64_image
$this->crud->addField([
    'label'        => "Front Image",
    'name'         => "front_image",
    'filename'     => "null", // set to null if not needed
    'type'         => 'base64_image',
    'aspect_ratio' => 0, // set to 0 to allow any aspect ratio
    'crop'         => true, // set to true to allow cropping, false to disable
    'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
]);

$this->crud->addField([
    'label'        => "Rear Image",
    'name'         => "rear_image",
    'filename'     => "null", // set to null if not needed
    'type'         => 'base64_image',
    'aspect_ratio' => 0, // set to 0 to allow any aspect ratio
    'crop'         => true, // set to true to allow cropping, false to disable
    'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
]);

$this->crud->addField([
    'label'        => "Dash Image",
    'name'         => "dash_image",
    'filename'     => "null", // set to null if not needed
    'type'         => 'base64_image',
    'aspect_ratio' => 0, // set to 0 to allow any aspect ratio
    'crop'         => true, // set to true to allow cropping, false to disable
    'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
]);

$this->crud->addField([
    'label'        => "Location Image",
    'name'         => "location_image",
    'filename'     => "null", // set to null if not needed
    'type'         => 'base64_image',
    'aspect_ratio' => 0, // set to 0 to allow any aspect ratio
    'crop'         => true, // set to true to allow cropping, false to disable
    'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
]);

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function issue(Request $request)
        {
          Ticket::create($request->all());
          return redirect()->route('home')->with('success', 'Job Created');
        }
}
