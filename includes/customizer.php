<?php
$customizer = array( // Panels
  "gsci-canadensis-options" => array(
    "ptitle" => "GSCI Options",
    "pdomain" => "canadensis-ps",
    "pcapability" => "edit_theme_options",
    "psections" => array( // Sections
      "gsci-canadensis-header" => array(
        "stitle" => "Header Elements",
        "sdomain" => "canadensis-ps",
        "spriority" => 115,
        "scapability" => "edit_theme_options",
        "sdescription" => "Additional elements to add to the header for clients",
        "sfields" => array( // Fields
          "canadensis_textarea_highest" => array(
            "fdefault" => "",
            "fcapability" => "edit_theme_options",
            "flabel" => "Highest Code",
            "fdomain" => "canadensis-ps",
            "fstype" => "option",
            "ftype" => "textarea",
            "fsettings" => "gsci_highest_code",
            "fattributes" => array(
              "placeholder" => "As close as you can get to the top.",
              "rows" => "10",
              "wrap" => "off"
            )
          ),
          "canadensis_textarea_prefetch" => array(
            "fdefault" => "",
            "fcapability" => "edit_theme_options",
            "flabel" => "Prefetch URLs",
            "fdomain" => "canadensis-ps",
            "fstype" => "option",
            "ftype" => "textarea",
            "fsettings" => "gsci_prefetch_urls",
            "fattributes" => array(
              "placeholder" => "Adds DNS Prefetch tags (DNS). One per line.",
              "rows" => "10",
              "wrap" => "off"
            )
          ),
          "canadensis_textarea_preconnect" => array(
            "fdefault" => "",
            "fcapability" => "edit_theme_options",
            "flabel" => "Preconnect URLs",
            "fdomain" => "canadensis-ps",
            "fstype" => "option",
            "ftype" => "textarea",
            "fsettings" => "gsci_preconnect_urls",
            "fattributes" => array(
              "placeholder" => "Adds preconnect tags (DNS + TCP + TLS). One per line.",
              "rows" => "10",
              "wrap" => "off"
            )
          ),
          "canadensis_textarea_preload" => array(
            "fdefault" => "",
            "fcapability" => "edit_theme_options",
            "flabel" => "Preload Resources",
            "fdomain" => "canadensis-ps",
            "fstype" => "option",
            "ftype" => "textarea",
            "fsettings" => "gsci_preload_resources",
            "fattributes" => array(
              "placeholder" => "Adds preload tags. One per line.",
              "rows" => "10",
              "wrap" => "off"
            )
          )
        ) // End Fields
      )
    )
  )
);
?>
