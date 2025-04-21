<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;

use App\Models\Vehicle;
use App\Models\VehicleAnalysis;
use App\Models\MaterialAllocation;
use App\Models\Vendor;
use App\Models\PurchaseOrder;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
   

    public function sendmailcontent($id)
    {
        $PurchaseOrder = PurchaseOrder::find($id);
        if ($PurchaseOrder) {
            // Update the mail_status field to 1
            $PurchaseOrder->mail_status = 1;
            
            // Save the changes to the database
            $PurchaseOrder->save();
            
            // Optionally, you can return a response or do something else here
        }
        $materials = MaterialAllocation::where('vehicle_id', $PurchaseOrder->vehicle_id)
                                        ->where('supplier_id', $PurchaseOrder->supplier_id)
                                        ->get();

        // Fetch vendor details
        $vendor = Vendor::find($PurchaseOrder->supplier_id);

        // Create new Dompdf instance
        $dompdf = new Dompdf();

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Purchase Order Table</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <style>
        body {
            background-color: pink; /* Set background color to pink */
            font-family: Times New Roman, Times, serif; /* Set font to Times New Roman */
        }

        .tables {
            border-collapse: collapse;
            width: 100%;
        }

        .tables th,
        .tables td {
            padding: 8px;
            text-align: left;
        }

        .table-bordered {
            border: 2px solid #000; /* Darker outer border */
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #666; /* Lighter inner border */
        }

        .material-table {
            width: 100%;
            border-collapse: collapse;
        }

        .material-table th,
        .material-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #666; /* Lighter inner border */
        }

        .material-table {
            border: 2px solid #000; /* Darker outer border */
        }

        .material-table th {
            background-color: #f2f2f2;
        }

        .material-table td {
            background-color: #fff;
        }
        </style>
        </head>
        <body>
            <div class="container">
                <h2 class="text-center mb-2"></h2>
                <table class="tables table-bordered">
                    <thead class="thead-light">
                    <tr>
                    <th>
                        <center>GST:</center>
                        <br>
                        <center>33AADPE9445Q1ZB</center>
                    </th>
                    <th colspan="2">
                        <center>PURCHASE ORDER</center>
                        <br>
                        <center style="font-size: 24px;">SAKTHI BODY WORKS</center>
                    </th>
                    <th>
                        PH: 044-2649-3853
                        <br><br>
                        CELL: 9884055851/52/53/54
                        <br><br>
                        E-mail: sakthibodyworks@gmail.com
                    </th>
                </tr>
                <tr>
                    <th colspan="4">
                        <center>(Govt. Major Approved Workshop)</center>
                        
                        <center> No -46, POONAMALLEE BYE PASS ROAD, POONAMALLEE, CHENNAI-600056</center>
                        
                        <center>SPECIALIST IN: BUS, TIPPER, TANKER, VAN, CARRIERS BODY BUILDING, PETROLEUM TANKER & FC WORKS</center>
                    </th>
                </tr>
                
                    </thead>
                </table>

                <h2 class="text-center mt-1 mb-2"></h2>
                <table class="tables table-bordered">
                    <thead class="thead-light">
                    <tr>
                    <th style="width: 50%; padding-right: 20px; vertical-align: top;">
                        To<br>' . $vendor->name . '<br>' . $vendor->billing_address . '
                    </th>
                    <th style="width: 50%; padding-left: 20px; vertical-align: top;" colspan="2">
                        PO. No: ' . $PurchaseOrder->purchase_id . '<hr style="border-top: 1px solid #000; background-color: pink;">Date: ' . date('d/m/Y', strtotime($PurchaseOrder->updated_at)) . '<hr style="border-top: 1px solid #000; background-color: pink;">GST: ' . $vendor->tax_number . '
                    </th>
                </tr>
                        <tr>
                            <th colspan="3">Dear Sir, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kindly supply the following items to sakthi body works.</th>
                        </tr>
                        <tr>
                        <th colspan="3">
                        Scope: ' . $PurchaseOrder->description . '</th>
                    </tr>
                    </thead>
                </table>
                <table class="material-table">
                <thead>
                    <tr>
                        <th  style="background-color: pink;">S.NO</th>
                        <th  style="background-color: pink;">Material Name</th>
                        <th  style="background-color: pink;">Brand</th>
                        <th  style="background-color: pink;">Quantity</th>
                        <th  style="background-color: pink;">Unit</th>
                        <th  style="background-color: pink;">Amount</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($materials as $key => $mat) {
            $val = $key + 1;
            $html .= '<tr>
                        <td  style="background-color: pink;">' . $val . '</td>
                        <td  style="background-color: pink;">' . $mat['material_name'] . '</td>
                        <td  style="background-color: pink;">' . $mat['brand'] . '</td>
                        <td  style="background-color: pink;">' . $mat['quantity'] . '</td>
                        <td  style="background-color: pink;">' . $mat['unit_of_measurement'] . '</td>
                        <td  style="background-color: pink;">' . $mat['estimated_amount'] . '</td>
                    </tr>';
        }

        $html .= '<tr>
                    <td colspan="5" style="background-color: pink;">Total </td>
                    <td style="background-color: pink;">' . $PurchaseOrder->subtotal . '</td>
                </tr>';     
        $html .= '<tr>
                    <td colspan="5" style="background-color: pink;">GST(%)</td>
                    <td style="background-color: pink;">' . $PurchaseOrder->gst_percentage . '</td>
                </tr>';
        $html .= '<tr>
                    <td colspan="5" style="background-color: pink;">Grand Total </td>
                    <td style="background-color: pink;">' . $PurchaseOrder->total_amount . '</td>
                </tr>';
        $html .= '<tr>
                    <th colspan="4" style="background-color: pink;"></th>
                    <th colspan="2" style="background-color: pink;">For SAKTHI BODY WORKS<br>
                        A.M.ELANGOVAN<br>
                        Authorised Signatory.</th>
                </tr>
                </tbody>
            </table>
            
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        </body>
        </html>
        ';

     
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();
       
    // Generate a descriptive file name for the Purchase Order
  // Set the filename in the desired format
$poFileName = 'PO-' . $vendor->name . '_' . date('YmdHis') . '.pdf';

// Define the PDF file path
$pdfFilePath = storage_path('app/public/po/' . $poFileName);

// Generate and save the PDF to storage/app/public/po directory
file_put_contents($pdfFilePath, $dompdf->output());

// Save the file path in the database
$PurchaseOrder->pdf_path = 'storage/app/public/po/' . $poFileName;
$PurchaseOrder->save();


    // Include PHPMailer files
        require base_path('phpmailer/src/Exception.php');
        require base_path('phpmailer/src/PHPMailer.php');
        require base_path('phpmailer/src/SMTP.php');

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'sakthibodyworks.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'info@sakthibodyworks.com';
            $mail->Password   = 'pz4QPmM~cWa+';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('info@sakthibodyworks.com', 'Sakthi Body Works');
            $mail->addAddress($vendor->email,$vendor->name);
             $mail->addAttachment($pdfFilePath, $poFileName); 
                        //Content
            $mail->Subject = 'Purchase Order - PO. No:'.$PurchaseOrder->purchase_id;

            $mail->isHTML(true);
            $mail->Body = '<p>Dear Sir/Madam,</p>
                           <p>Kindly supply the following items to Sakthi Body Works:</p>
                           <p>Attached, you will find the Purchase Order (PO) document detailing the items requested. Please review the PO and let us know if everything is accurate.</p>
                           <p>If you have any questions or require further clarification, feel free to contact us.</p>
                           <p>We kindly request that you acknowledge receipt of this order and provide an estimated delivery date at your earliest convenience.</p>
                           <p>Thank you for your prompt attention to this matter. We look forward to continuing our successful partnership.</p>
                           <p>Best regards,<br>
                            A.M.ELANGOVAN<br>
                            SAKTHI BODY WORKS<br>
                            9884055851</p>';

            // Send email
            $mail->send();

         return redirect()->back()->with('success', 'Message Has been Sent');
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


    }
}
