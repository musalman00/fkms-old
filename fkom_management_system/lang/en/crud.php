<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'payments' => [
        'name' => 'Payments',
        'index_title' => 'Payments List',
        'new_title' => 'New Payment',
        'create_title' => 'Create Payment',
        'edit_title' => 'Edit Payment',
        'show_title' => 'Show Payment',
        'inputs' => [
            'user_id' => 'User',
            'amount' => 'Amount',
            'qr_picture' => 'Qr Picture',
            'status' => 'Status',
        ],
    ],

    'promotions' => [
        'name' => 'Promotions',
        'index_title' => 'Promotions List',
        'new_title' => 'New Promotion',
        'create_title' => 'Create Promotion',
        'edit_title' => 'Edit Promotion',
        'show_title' => 'Show Promotion',
        'inputs' => [
            'kiosk_participant_id' => 'Kiosk Participant',
            'picture' => 'Picture',
            'description' => 'Description',
            'publish_time' => 'Publish Time',
            'promotion_ends' => 'Promotion Ends',
            'status' => 'Status',
        ],
    ],

    'kiosks' => [
        'name' => 'Kiosks',
        'index_title' => 'Kiosks List',
        'new_title' => 'New Kiosk',
        'create_title' => 'Create Kiosk',
        'edit_title' => 'Edit Kiosk',
        'show_title' => 'Show Kiosk',
        'inputs' => [
            'number' => 'Number',
            'name' => 'Name',
            'description' => 'Description',
        ],
    ],

    'kiosk_participants' => [
        'name' => 'Kiosk Participants',
        'index_title' => 'KioskParticipants List',
        'new_title' => 'New Kiosk participant',
        'create_title' => 'Create KioskParticipant',
        'edit_title' => 'Edit KioskParticipant',
        'show_title' => 'Show KioskParticipant',
        'inputs' => [
            'user_id' => 'User',
            'kiosk_id' => 'Kiosk',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'applications' => [
        'name' => 'Applications',
        'index_title' => 'Applications List',
        'new_title' => 'New Application',
        'create_title' => 'Create Application',
        'edit_title' => 'Edit Application',
        'show_title' => 'Show Application',
        'inputs' => [
            'kiosk_id' => 'Kiosk',
            'user_id' => 'User',
            'payment_id' => 'Payment',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'operating_day' => 'Operating Day',
            'operating_hour' => 'Operating Hour',
            'business_type' => 'Business Type',
            'status' => 'Status',
            'reason_reject' => 'Reason Reject',
        ],
    ],

    'complaints' => [
        'name' => 'Complaints',
        'index_title' => 'Complaints List',
        'new_title' => 'New Complaint',
        'create_title' => 'Create Complaint',
        'edit_title' => 'Edit Complaint',
        'show_title' => 'Show Complaint',
        'inputs' => [
            'kiosk_participant_id' => 'Kiosk Participant',
            'title' => 'Title',
            'category' => 'Category',
            'description' => 'Description',
            'attachment' => 'Attachment',
            'technician_assign' => 'Technician Assign',
            'reply' => 'Reply',
            'status' => 'Status',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
