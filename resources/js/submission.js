// Submission Form Validation and File Upload Handling

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('submissionForm');
    const serviceSelect = document.getElementById('service_id');
    const serviceInfo = document.getElementById('serviceInfo');
    const documentUpload = document.getElementById('documentUpload');
    const documentInput = document.getElementById('document');
    const documentText = document.getElementById('documentText');
    const proofUpload = document.getElementById('proofUpload');
    const proofInput = document.getElementById('initial_payment_proof');
    const proofText = document.getElementById('proofText');
    const referenceInput = document.getElementById('initial_payment_reference');
    const submitBtn = document.getElementById('submitBtn');
    const initialAmount = document.getElementById('initialAmount');
    const finalAmount = document.getElementById('finalAmount');
    const totalAmount = document.getElementById('totalAmount');

    // Check if submission form exists on this page
    if (!form || !serviceSelect || !documentUpload || !documentInput || !proofUpload || !proofInput || !referenceInput || !submitBtn) {
        return; // Exit if submission form is not on this page
    }

    // Service selection handler
    if (serviceSelect) {
        serviceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const price = parseFloat(selectedOption.dataset.price);
                const initial = parseFloat(selectedOption.dataset.initial);
                const final = parseFloat(selectedOption.dataset.final);
                
                if (initialAmount) {
                    initialAmount.textContent = '₱' + initial.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
                if (finalAmount) {
                    finalAmount.textContent = '₱' + final.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
                if (totalAmount) {
                    totalAmount.textContent = '₱' + price.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
                if (serviceInfo) {
                    serviceInfo.style.display = 'block';
                }
            } else {
                if (serviceInfo) {
                    serviceInfo.style.display = 'none';
                }
            }
            checkSubmitButton();
        });
    }

    // Document upload handler
    if (documentUpload && documentInput) {
        // Click on upload area (but not the button itself)
        documentUpload.addEventListener('click', function(e) {
            if (e.target !== documentText) {
                documentInput.click();
            }
        });

        // Click on button directly
        if (documentText) {
            documentText.addEventListener('click', function(e) {
                e.stopPropagation();
                documentInput.click();
            });
        }

        documentInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                if (documentText) {
                    documentText.textContent = file.name;
                }
                documentUpload.classList.add('has-file');
            } else {
                if (documentText) {
                    documentText.textContent = 'Click to upload or drag and drop';
                }
                documentUpload.classList.remove('has-file');
            }
            checkSubmitButton();
        });
    }

    // Payment proof upload handler
    if (proofUpload && proofInput) {
        // Click on upload area (but not the button itself)
        proofUpload.addEventListener('click', function(e) {
            if (e.target !== proofText) {
                proofInput.click();
            }
        });

        // Click on button directly
        if (proofText) {
            proofText.addEventListener('click', function(e) {
                e.stopPropagation();
                proofInput.click();
            });
        }

        proofInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                if (proofText) {
                    proofText.textContent = file.name;
                }
                proofUpload.classList.add('has-file');
            } else {
                if (proofText) {
                    proofText.textContent = 'Click to upload payment proof';
                }
                proofUpload.classList.remove('has-file');
            }
            checkSubmitButton();
        });
    }

    // Reference number handler
    if (referenceInput) {
        referenceInput.addEventListener('input', function() {
            checkSubmitButton();
        });
    }

    // Check if submit button should be enabled
    function checkSubmitButton() {
        if (!serviceSelect || !documentInput || !proofInput || !referenceInput || !submitBtn) return;
        
        const hasService = serviceSelect.value !== '';
        const hasDocument = documentInput.files.length > 0;
        const hasProof = proofInput.files.length > 0;
        const hasReference = referenceInput.value.trim() !== '';

        if (hasService && hasDocument && hasProof && hasReference) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Initial check
    checkSubmitButton();
});

