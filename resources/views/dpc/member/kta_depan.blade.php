<html>
    <head>
        <title>Cetak KTA DEPAN</title>
        <style>
            /** 
            * Set the margins of the PDF to 0
            * so the background image will cover the entire page.
            **/
            @page {
                margin: 0cm 0cm;
            }

            /**
            * Define the real margins of the content of your PDF
            * Here you will fix the margins of the header and footer
            * Of your background image.
            **/
            body {
                margin-top:    5mm;
                margin-left:   2mm;
                margin-right:  1cm;
            }
            /** 
            * Define the width, height, margins and position of the watermark.
            **/
            #watermark {
                position: fixed;
                bottom:   0px;
                left:     0px;
                /** The width and height may change 
                    according to the dimensions of your letterhead
                **/
                width:    85.6mm;
                height:   53.98mm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
      </style>
    </head>
    <body>
        
        <div id="watermark" style="overflow:auto;">
            <img     src="{{asset('/uploads/img/pic_kta/' .$settings->pic_kta_depan  ) }}" height="100%" width="100%" />
        </div>

    </body>
</html>