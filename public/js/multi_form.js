$(document).ready(function () {
    const prevBtns = document.querySelectorAll(".btn-prev");
    const nextBtns = document.querySelectorAll(".btn-next");
    const progress = document.getElementById("progress");
    const formSteps = document.querySelectorAll(".form-step");
    const progressSteps = document.querySelectorAll(".progress-step");
    const experiencesGroup = document.querySelector(".experiences-group");
    
    let formStepsNum = 0;
    let experienceNum = 1;

    // function updateFormSteps() {
    //     formSteps.forEach(formStep => {
    //         formStep.classList.contains("active") &&
    //             formStep.classList.remove("active");
    //     })
    //     formSteps[formStepsNum].classList.add("active");
    // }


    function updateFormSteps() {
        formSteps.forEach((formStep, index) => {
            if (index === formStepsNum) {
                formStep.classList.add("active");  // Show current step
                formStep.style.display = "block";  // Ensure visibility
            } else {
                formStep.classList.remove("active"); // Remove active class
                formStep.style.display = "none";  // Hide all other steps
            }
        });
    }

     

    function updateProgressBar() {
        progressSteps.forEach((progressStep, idx) => {
            if (idx < formStepsNum + 1) {
                progressStep.classList.add("active");
            } else {
                progressStep.classList.remove("active");
            }
        })
        const progressActive = document.querySelectorAll(".progress-step.active");
        progress.style.width = ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + '%';
    }
    
    nextBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            let currentStep = document.querySelector(".form-step.active");
    
            // Check which form is active and validate only that form
            if (currentStep.id === "form-1") {
                if ($("#form1").valid()) {
                    formStepsNum++;
                    updateFormSteps();
                    updateProgressBar();
                } else {
                    return false;
                }
            } else if (currentStep.id === "form-2") {
                if ($("#form2").valid()) {
                    formStepsNum++;
                    updateFormSteps();
                    updateProgressBar();
                } else {
                    return false;
                }
            }
        });
    });

    // prevBtns.forEach(btn => {
    //     btn.addEventListener("click", function () {
    //         formStepsNum--;
    //         updateFormSteps();
    //         updateProgressBar();
    //     })
    // });

    document.querySelectorAll(".btn-prev").forEach(btn => {
        btn.addEventListener("click", function () {
            if (formStepsNum > 0) {
                formStepsNum--;
                updateFormSteps();
                updateProgressBar();
            }
        });
    });


    $("#form1").validate({
        rules: {
            company_name: {
                required: true,
            },
            company_type: {
                required: true,
            },
            name: {
                required: true,
            },
            website: {
                required: true,
            },
            project_type: {
                required: true,
            },
            launch_date: {
                required: true,
            },
            country: {
                required: true,
            },
            team_size: {
                required: true,
            },
            business_modal: {
                required: true,
            },
            company_description: {
                required: true,
            },
            company_technology: {
                required: true,
            }
            
        },
        messages: {
            company_name: "Company name is required.",
            company_type: "Company type is required.",
            name: "Name is required.",
            website: "website is required.",
            project_type: "Project type is required.",
            launch_date: "Launch date is required.",
            country: "country name is required.",
            team_size: "Team Size is required.",
            business_modal: "Business model is required.",
            company_description: "Description is required.",
            company_technology: "Technology type is required.",
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
    });

    $("#form2").validate({
        rules: {
            growth_opportunity: {
                required: true,
            },
            finanical_data: {
                required: true,
            },
            matrix: {
                required: true,
            },
            data_room: {
                required: true,
            },
            marketing: {
                required: true,
            },
            price: {
                required: true,
            },
            offer_type: {
                required: true,
            },
            propsal_price: {
                required: true,
            },
            offer_note: {
                required: true,
            },
            // phone_number: {
            //     required: true,
            // },
            email_address: {
                required: true,
            },
            share_percentange: {
                required: true,
            },
            nda: {
                required: true,
            },
            start_date: {
                required: true,
            },
            reason_for_sale: {
                required: true,
            }
        },
        messages: {
            growth_opportunity: "Growth filed is required.",
            finanical_data: "Financial Data field is required.",
            matrix: "Matrix field is required.",
            data_room: "Data room field is required.",
            marketing: "Marketing field is required.",
            price: "Price field is required.",
            offer_type: "Offer type field is required.",
            propsal_price: "proposal price field is required.",
            offer_note: "Offer note field is required.",
            // phone_number: "Phone number field is required.",
            email_address: "Email address field is required.",
            share_percentange: "Share Percentage field is required.",
            nda: "NDA field is required.",
            start_date: "Start date field is required.",
            reason_for_sale:"Reason for sale is required",

        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
    });


});
