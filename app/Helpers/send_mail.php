<?php

use App\Models\EmailTemplate;

function send_mail_api($to, $sub, $msg)
{
    $sub = urlencode($sub);
    $to = $to;
    $headers = ['Content-Type: application/json'];
    $array = ['msg' => $msg];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.crisil.xyz/mail/mailpost.php?id=35&to=$to&subject=$sub");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result_data = curl_exec($ch);
    $response = json_decode($result_data, true);
    return true;
}



function send_mail($mailid, $subject, $values)
{

    $var1 = $var2 = $var3 = $var4 = $var5 = $var6 = $var7 = $var8 = $var9 = $var10 = "";

    if (empty($values)) {
    } else {
        if (!empty($values["var1"])) {
            $var1 = $values["var1"];
        }
        if (!empty($values["var2"])) {
            $var2 = $values["var2"];
        }
        if (!empty($values["var3"])) {
            $var3 = $values["var3"];
        }
        if (!empty($values["var4"])) {
            $var4 = $values["var4"];
        }
        if (!empty($values["var5"])) {
            $var5 = $values["var5"];
        }
        if (!empty($values["var6"])) {
            $var6 = $values["var6"];
        }
        if (!empty($values["var7"])) {
            $var7 = $values["var7"];
        }
        if (!empty($values["var8"])) {
            $var8 = $values["var8"];
        }
        if (!empty($values["var9"])) {
            $var9 = $values["var9"];
        }
        if (!empty($values["var10"])) {
            $var10 = $values["var10"];
        }
    }

    // $getdata = EmailTemplate::where(array('module_id'=>$moduleid))->get();

    // foreach ($getdata as $datav) {
    //     $template_content = $datav->content;
    //     $template_content = str_replace("@var1", $var1, $template_content);
    //     $template_content = str_replace("@var2", $var2, $template_content);
    //     $template_content = str_replace("@var3", $var3, $template_content);
    //     $template_content = str_replace("@var4", $var4, $template_content);
    //     $template_content = str_replace("@var5", $var5, $template_content);
    //     $template_content = str_replace("@var6", $var6, $template_content);
    //     $template_content = str_replace("@var7", $var7, $template_content);
    //     $template_content = str_replace("@var8", $var8, $template_content);
    //     $template_content = str_replace("@var9", $var9, $template_content);
    //     $template_content = str_replace("@var10", $var10, $template_content);

    //     $message = file_get_contents(asset('template/order_email_template.html'));

    //     $message = str_replace('%title%', $datav->title, $message);
    //     $message = str_replace('%content%', $template_content, $message);
    //     $subject = $datav->subject;
    // }

    send_mail_api($mailid, $subject, $values);

    if ($mailid != 'customer.support@secondmedic.com') {
        send_mail_api("customer.support@secondmedic.com", $subject, $values);
    }
}
