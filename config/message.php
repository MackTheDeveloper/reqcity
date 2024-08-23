<?php

return [

    /* All authenctication related messages are mentioned below */

    'AuthMessages' => [
        'AccountCreate' => 'Your account has been created sucessfully.',
        'AccountUpdate' => 'Your detail has been updated sucessfully.',
        'NotVerified' => 'Your email is not verified yet! Please verify it first for accessing account.',
        'NotActive' => 'Your account is not activated yet. Please contact to admin!',
        'AccountDelete' => 'This account is permanently deleted from the system. Please contact to administration.',
        'InvalidCredentials' => 'Email & Password are incorrect.',
        'RoleNotFound' => 'These credentials do not match our records. Please contact to admin!',
        'CustomerEmailAlreadyExists' => 'Email is already exists. Kindly use another email.',
        'EmailNotFound' => 'Sorry the email you entered is not available in our record!',
        'EmailSentSuccess' => 'Reset password mail has been successfully sent to your email please check and verify.',
        'EmailExists' => 'Email is already exists',
        'PhoneExists' => 'Phone is already exists',
        'AccountNotFound' => "account does not exist!",
        'InvalidEmail' => "Invalid email address. Try again.",
        'InvalidPassword' => "Invalid password. Try again.",
        'InvalidPhone' => "Invalid mobile number. Try again.",
        'InvalidPhoneForgot' => "We're sorry. We weren't able to identify you given the information provided. Please enter email address.",
        'InvalidEmailForgot' => "We're sorry. We weren't able to identify you given the information provided.",
        'loginSuccess' => "Login successful",
        'AccountInactive' => "Your Account is Inactive please contact admin.",
        'AccountSuspended' => "Your Account is Suspended please contact admin.",
        'mailSent' => "Mail has been Sent successfully",
        'subscribeSuccessfully' => "You have subscribed successfully",
    ],

    'pricingDetails' => [
        'company' => [
            'labels' => [
                'saveUpTo' => '(Save Upto 20%)',
                'saveings' => '(Savings of $500)',
                'title1' => 'Membership Pricing',
                'description1' => 'Select the plan that works best for you.',
                'title2' => 'Less time and effort for your hiring.',
                'description2' => 'ReqCity’s simple and powerful platform help you screen and hire faster.',
            ],
        ],
        'recruiter' => [
            'labels' => [
                'saveUpTo' => '(Save Upto 20%)',
                'saveings' => '(Savings of $300)',
                'title1' => 'Membership Pricing',
                'description1' => 'Select the plan that works best for you.',
                'title2' => 'Get paid for your efforts upfront',
                'description2' => "ReqCity's simple and powerful platform puts your candidates in front of the hiring manager faster",
            ],
        ],

    ],


    'Users' => [
        'AddUserSuccess' => 'User added successfully!',
        'UpdateUserSuccess' => 'User updated successfully!',
        'DeleteUserSuccess' => 'User deleted successfully!',
        'FanUpdate' => 'Fan Updated Successfully',
    ],

    'Role' => [
        'RoleAddSuccess' => 'Role added successfully!',
        'RoleUpdateSuccess' => 'Role updated successfully!'
    ],

    'Customer' => [
        'RegisterMailSent' => 'Registration mail sent successfully. Please check your mail for verify account.',
    ],
    'LocationGroup' => [
        'AreaExists' => 'Area already exists in another location.',
        'GroupExists' => 'Group name already exists in another location.',
    ],
    'SlotAllocation' => [
        'Add' => 'Slot added successfully.',
        'Update' => 'Slot updated successfully.',
    ],
    'BookDemoRequest' => [
        'Add' => 'Thank you for booking demo request. We will get back to you soon.',
    ],
    'NotificationMsg' => [
        'jobpostadded' => 'A candidate has been submitted on {PARAM} job post by recuiter.',
        'jobpostaddedByCandidateSpecialist' => 'A candidate has been submitted on {PARAM} job post by candidate specialist.',
        'jobpostaddedCandidate' => 'Your job post on {PARAM} is submitted successfully by candidate specialist.',
    ],

    "frontendMessages" =>[
        "subscription" => [
            "cancel" => "You Have cancelled your subscription",
            "cancel-scheduled" => "You Have cancelled your upgrade subscription plan",
            "upgrade" => "We have received your request to upgrade subscription. It will reflect from next billing cycle.",
        ],
        "communicationMgt" => [
            "add" => "Template has been added successfully",
            "update" => "Template has been updated successfully",
            "delete" => "Template has been deleted successfully",
        ],
        "questionnaire" => [
            "add" => "Questionnaire Template has been added successfully",
            "update" => "Questionnaire Template has been updated successfully",
            "delete" => "Questionnaire Template has been deleted successfully",
        ],
        "address" => [
            "add" => "Address has been added successfully",
            "update" => "Address has been updated successfully",
            "delete" => "Address has been deleted successfully",
        ],
        "jobPost" => [
            "addJobDetails" => "Job details has been added successfully",
            "updateJobDetails" => "Job details has been updated successfully",
            "updateJobCommunication" => "Job commission has been updated successfully",
            "updateJobQuestionnaire" => "Job questionnaire has been updated successfully",
            "paymentConfirmSuccess" => "Job Payment done successfully",
            "paymentConfirmFailed" => "Job Payment failed",
            "saveAsDraft" => "Your job post has been saved as draft",
            "jobPay" => "Job details has been updated successfully. please make a payment to activate this job",
            "jobFavourite" => 'Job has been added in your favorites',
            "jobUnFavourite" => 'Job has been removed from your favorites',
            "jobFavouriteLogin" => 'Please login to save this job.',
        ],
        "jobPostApply" => [
            "candidateSubmit" => "Candidate Information saved successfully",
            "candidateSubmitQuestionnaire" => "Candidate Questionnaire saved successfully",
            "applied" => "You have applied for this job successfully",
            "jobAppliedLogin" => "Please login to apply for this job",
        ],
        "notification" => [
            "delete" => "Notification has been deleted successfully",
            "read"=>"Notification mark as read Successfully!",
            "unread"=>"Notification mark as unread Successfully!",
            "noupdates"=>"There are no updates for you.",
        ],
        "error" =>[
            "wrong" => "Something went wrong !",
        ],
        "candidate" =>[
            "add" => "Candidate has been added sucessfully",
            "update" => "Candidate has been updated sucessfully",
            "delete" => "Candidate has been deleted sucessfully",
            "approved" => "Candidate has been approved sucessfully",
            "reject" => "Candidate has been rejected sucessfully",
        ],
        'BalanceTransfer' => [
            'Add' => 'Balance transfer request has been submitted sucessfully.',
        ],
        'comapnyjob' => [
            'changestatus' => 'Job status has been updated sucessfully.',
        ],
        'recordNotFound' => 'No records founds for your search criteria'
     ]
];
