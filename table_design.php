<style>

.dataTable {
    width: 100% !important;
    border-collapse: collapse; /* Neat borders */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    border-top: 7px solid #014bae !important;
    border-radius: 7px !important;
    border-bottom: 7px solid #014bae !important;   
   
}

.dataTables_info, label  {
    font-family: "PMedium";
    font-size: 1rem;
    color: #012049 !important; 
}

.dataTables_paginate {
    font-family: "PMedium";
    font-size: 1rem;
    color: #014bae !important; 
    padding: .3em 0.8em !important;
}
.paginate_button.current {

    border: 2px solid #014bae !important;
    color: white !important;
  
}



.paginate_button:hover {
background: #014bae !important;
border: none !important;
transform: none !important;
transition: none !important;

  
}

.paginate_button {
background: #014bae;

  
}

.paginate_button.previous.disabled:hover {
background: transparent !important;
border: 0 !important;
}

.paginate_button.previous.disabled{
background: transparent !important;
border: 0 !important;
}

.paginate_button.next.disabled:hover {
background: transparent !important;
border: 0 !important;

}

.paginate_button.next.disabled {
background: transparent !important;
border: 0 !important;

}

.paginate_button.current:hover {
    
    border: 2px solid #014bae !important;
    background: transparent !important;

 
  
}

select {
    padding: 2px !important;
    z-index: 2 !important;
    border-radius: 5px;
    border: 2px solid #012049 !important;
    padding: 0 5px !important;
    cursor: pointer !important;
}
/* Table cell styles */
th, td {

    text-align: center; /* Center text horizontally */
    vertical-align: middle; /* Center text vertically */

}

td {
    border: none !important; /* Thicker border with custom color */
}

/* General container adjustments */
.container-fluid {
    width: 100%; /* Ensure it spans the full width */
    overflow: visible !important; /* Prevent it from scrolling on its own */
}

.dataTables_wrapper {
    z-index: 1 !important;
    margin-bottom: 30px !important;

    
}

/* Table Header */
th {
    background-color: #014bae;
    color: white;
    text-align: center !important; /* Horizontal alignment */
    vertical-align: middle !important; /* Vertical alignment */
    border: none !important; /* Thicker border with custom color */
    font-size: 1rem;
    font-family: "PSemiBold" !important;
    height: 30px; /* Adjust as needed to make the header row taller */
    
}

/* Table Rows */
td {
    text-align: center;
    padding: 10px !important;
    vertical-align: middle !important;
    font-family: "PRegular" !important;
    font-size: 0.9rem;
    color: #333;
    border-bottom: 1px solid #ddd;
}

.row h1 {
    color: white;
            font-family: 'PExBold' !important;
            font-size: 2.2rem;
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
            margin-top: 30px;
            letter-spacing: 3px;

            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
}

.btn-success {
    background-color: #2c91c9	;
    font-size: 0.9rem !important;
    border: none;
    font-family: "PSemiBold";
    vertical-align: middle;
}

.btn-success:hover {
      background-color:  #267ea9;
    }

.btn-danger {
    font-size: 0.9rem !important;
    border: none;
    font-family: "PSemiBold";
    margin-bottom: 3px !important;

}



.button-info {
    background-color: #014bae;
    padding: 7px;
    border: none !important;
}

.fa-search, .fa-sync {
font-size: 1.1rem !important;
color: white;
}

.btn-container {
    margin-left: 5px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}

/* Alternate Row Colors */
tr:nth-child(even) {
    background-color: #e7f3ff;
}

/* Hover Effect */
tr:hover {
    background-color: #e6f7ff;
    transition: background-color 0.3s ease-in-out;
}

/* Responsive Table */
@media (max-width: 768px) {
    table {
        font-size: 0.8rem;
    }
    th, td {
        padding: 10px;
    }
}



.searchbox{
    display: flex; /* Aligns input and button in a row */
    flex-wrap: wrap;
    row-gap: 10px;
    align-items: center; /* Vertical alignment */
    justify-content: space-between; /* Space between input and button */
    background: #014bae;
    padding:13px;
    width:600px;
    margin:auto;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
    box-sizing:border-box;
    border-radius:6px;
    -webkit-box-shadow: 
    0 2px 4px 0 rgba(1, 75, 174, 0.83),
    0 10px 15px 0 rgba(1, 75, 174, 0.12),
    0 -2px 6px 1px rgba(1, 75, 174, 0.55) inset, 
    0 2px 4px 2px rgba(1, 75, 174, 0.83) inset;
-moz-box-shadow: 
    0 2px 4px 0 rgba(1, 75, 174, 0.83),
    0 10px 15px 0 rgba(1, 75, 174, 0.12),
    0 -2px 6px 1px rgba(1, 75, 174, 0.55) inset, 
    0 2px 4px 2px rgba(1, 75, 174, 0.83) inset;
box-shadow: 
    0 2px 4px 0 rgba(1, 75, 174, 0.83),
    0 10px 15px 0 rgba(1, 75, 174, 0.12),
    0 -2px 6px 1px rgba(1, 75, 174, 0.55) inset, 
    0 2px 4px 2px rgba(1, 75, 174, 0.83) inset;
}

.left-search {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}


.custom-date-search {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px; /* Space between labels and inputs */
    margin-top: 10px;

}

.custom-date-search .form-label {
    margin-bottom: 0; /* Remove bottom margin from labels */
    color: white !important;
    font-family: "PSemiBold" !important;
}

.custom-date-search .form-control {
    width: auto; /* Allow input fields to resize based on content */
    max-width: 150px; /* Adjust the width of input fields as needed */
    font-family: "PRegular" !important;
    box-sizing: border-box;
    border:none;
    background-color:#fffbf8;
    border-radius:6px;
    -webkit-box-shadow:
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
    -moz-box-shadow: 
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
    box-shadow:
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;

}

.custom-date-search .form-control:focus {
outline:0;
    color: black;
    font-family: "PRegular";
}

.searchinp{
    width: calc(100% - 45px);
    height:40px;
    padding-left:15px;
    border-radius:6px;
    box-sizing: border-box;
    border:none;
    color:#939393;
    font-weight:500;
    background-color:#fffbf8;
    -webkit-box-shadow:
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
    -moz-box-shadow: 
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
    box-shadow:
        0 -2px 2px 0 rgba(199, 199, 199, 0.55),
        0 1px 1px 0 #fff,
        0 2px 2px 1px #fafafa,
        0 2px 4px 0 #b2b2b2 inset,
        0 -1px 1px 0 #f2f2f2 inset,
        0 15px 15px 0 rgba(41, 41, 41, 0.09) inset;
}
.searchbtn, .reloadbtn {
    width:40px;
    height:40px;
    border:none;
    cursor:pointer;
    padding: 0 5px !important;
    background-color: transparent;
    color: white !important;
}

.search-row {
    display: flex;
    flex-direction: row;
    align-items: center; /* Centers vertically */
    justify-content: center !important; /* Centers horizontally */
    margin-bottom: 40px !important;

}
.searchinp:focus{
    outline:0;
    color: black;
    font-family: "PRegular";
}
.searchinp::placeholder {
    font-family: "PRegular";
}
.fa-search {
    color: white;
    font-size: 1.1rem;
}

form label {
         
         font-size: 1rem;
         color: #012049 !important;
         font-family: "PSemiBold";
         text-align: left;
     }

.btn-primary {
        font-size: 0.9rem !important;
        margin-left: 4px;
        background-color: #17a2b8;
}

.btn-primary:hover {
    background-color: #138496; /* Darker shade for hover */
}
  
 
form select  {
                font-family: "PMedium" !important;
                font-size: 1rem;
                border-radius: 5px;
                border: 2px solid #012049;
                padding: 0 5px;
                cursor: pointer;
                margin-left: 5px;
                text-align: center;
                margin-bottom: 10px;
                color: #012049;
                            
}


.form-control option:hover {
    background-color: #2c91c9; /* Light gray background on hover */
    color: #000; /* Darker text on hover */
}


.form-control:focus {
    border-color: black; /* Highlight border on focus */
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3); /* Subtle shadow on focus */ 
}

.form-buttons {
    display: flex; /* Aligns forms in a row */
    gap: 10px; /* Adds space between the buttons */    align-items: center; /* Ensures buttons align vertically */
}

.form-buttons form {
    margin: 0; /* Removes default margins from forms */
}

.btnexpex, .btnexpdf {
    padding: 5px 20px; /* Adjusts button size */
    font-size: 16px; /* Adjusts font size */
    border-radius: 5px; /* Rounds button corners */
    background-color: white; /* Light background color */
    font-family: "PSemiBold";
    cursor: pointer; /* Changes cursor to pointer */
    margin-bottom: 30px;
}
.btnexpex {
    background-color: #388E3C; /* Darker background on hover */
    color: white; /* White text on hover */
}

.btnexpex:hover {
    background-color: #2C6B2F !important; 
    color: white; /* White text */
}

.btnexpdf {
    background-color: #D32F2F; /* Darker background on hover */
    color: white; /* White text on hover */
}

.btnexpdf:hover {
    background-color: #9A1C1C !important; 
    color: white; /* White text */
}

.btnexpex i,.btnexpdf i {
    margin-right: 5px; /* Adds spacing between icon and text */

}

.btnexpex:hover {
    background-color: #388E3C; /* Darker background on hover */
    color: white; /* White text on hover */
}

.btnexpdf:hover {
    background-color: #D32F2F; /* Darker background on hover */
    color: white; /* White text on hover */
}

.toasterr {
        position: fixed;
        font-family: "Poppins";
        z-index: 1000;
        top: 25px;
        right: 30px;
        border-radius: 12px;
        background: #fff;
        box-sizing: content-box;
        padding: 20px 35px 20px 25px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        border-left: 6px solid #4070f4;
        overflow: hidden;
        transform: translateX(calc(100% + 30px));
        opacity: 0;
        visibility: hidden;
        transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.35), opacity 0.5s ease-out;
        width: auto;
        /* Adjust width based on content */
        max-width: 650px;
        /* Optional: limit the maximum width */
        white-space: nowrap;
        /* Prevent the text from wrapping to the next line */
    }


    .toasterr.active {
        transform: translateX(0%);
        opacity: 1 !important;
        visibility: visible;
    }

    .toasterr .toasterr-content {
        display: flex;
        align-items: center;
    }

    .toasterr-content .check {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 35px;
        width: 35px;
        background-color: #4070f4;
        color: #fff;
        font-size: 20px;
        border-radius: 50%;
    }

    .toasterr-content .message {
        display: flex;
        flex-direction: column;
        margin: 0 20px;
        white-space: nowrap;
        /* Prevents text from wrapping */
        overflow: hidden;
        /* Ensures that overflowing text doesn't show */
        text-overflow: ellipsis;
        /* Adds '...' at the end if the text is too long */
    }


    .message .text {
        text-align: left;
        font-size: 1rem;
        font-weight: 400;
        color: #666666;
    }

    .message .text.text-1 {
        font-family: "PSemiBold";
        font-size: 1.1rem;
    }

    .toasterr .close {
        position: absolute;
        top: 10px;
        right: 15px;
        padding: 5px;
        cursor: pointer;
        color: #4070f4;
        z-index: 1000;
        opacity: 1;
        font-size: 1.4rem !important;
    }

    .toasterr .close-error {
        color: #D32F2F !important;
    }

    .toasterr .close:hover {

        color: #4070f4 !important;
    }

    .toasterr .close-error:hover {
        color: #D32F2F !important;
    }

    .toasterr .progresserr {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: #ddd !important;
    }

    .toasterr .progresserr:before {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        height: 100%;
        width: 100%;
        background-color: #4070f4;
    }

    .toasterr .progresserr-error:before {

        background-color: #D32F2F;
    }

    .progresserr.active:before {
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        100% {
            right: 100%;
        }
    }

    .comfirm-slt, .cancel-btn-slt {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}


.popup-slt {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4);
    box-sizing: content-box;
    z-index: 1000000;
}

.popup-content-slt {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    width: 400px;
    white-space:initial;
}

.popup-content-slt h2 {
    margin-bottom: 10px;
    font-size: 1.3rem;
    font-family: "PBold";
}

.popup-content-slt p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.popup-buttons-slt {
    display: flex;
    justify-content: space-around;
}

.confirm-slt {
    background-color: #D32F2F;
    color: white;
}

.cancel-btn-slt, .cancel-btn-slt:hover {
    background-color: white;
    color: #d32f2f;
    border: 2px solid #d32f2f;
}



.hidden {
  
    opacity: 0;
    visibility: hidden;
}

.comfirm-slt, .cancel-btn-slt {
    padding: 10px 30px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}


#archiveSelected, #retrieveSelected {
    font-size: 1.1rem !important;
    padding: 10px 25px;
    border-radius: 10px; /* Top-left, Top-right, Bottom-right, Bottom-left */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Horizontal, Vertical, Blur, Spread */
    margin-left: 5px;

}

#retrieveSelected {
    background-color: #1e79ac !important;
}

#selectAllBtn {
    font-size: 1.1rem !important;
    padding: 10px 25px;
    border-radius: 10px; /* Top-left, Top-right, Bottom-right, Bottom-left */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Horizontal, Vertical, Blur, Spread */
    font-family: "PSemiBold";
    color: white;
    background-color: #014bae;
}

#selectAllBtn:hover {
    background-color: #01378e;
}
</style>
