<?php namespace ProcessWire;

/**
 * ProcessLegalDocs — Jurisdictions & Document Definitions
 */

class ProcessLegalDocsConfig {

    /**
     * All supported jurisdictions
     */
    public static function getJurisdictions(): array {
        return [
            'eu_gdpr'    => ['name' => 'EU / GDPR',                      'region' => 'Europe'],
            'uk_gdpr'    => ['name' => 'UK / UK GDPR',                    'region' => 'Europe'],
            'eea_gdpr'   => ['name' => 'EEA / GDPR',                      'region' => 'Europe'],
            'ch_fadp'    => ['name' => 'Switzerland / FADP',              'region' => 'Europe'],
            'de_gdpr'    => ['name' => 'Germany / GDPR + BDSG + TTDSG',   'region' => 'Europe'],
            'fr_gdpr'    => ['name' => 'France / GDPR + CNIL',            'region' => 'Europe'],
            'es_gdpr'    => ['name' => 'Spain / GDPR + LOPDGDD',          'region' => 'Europe'],
            'it_gdpr'    => ['name' => 'Italy / GDPR + Privacy Code',      'region' => 'Europe'],
            'nl_gdpr'    => ['name' => 'Netherlands / GDPR + UAVG',        'region' => 'Europe'],
            'ie_gdpr'    => ['name' => 'Ireland / GDPR + Data Protection Act', 'region' => 'Europe'],
            'at_gdpr'    => ['name' => 'Austria / GDPR + DSG',             'region' => 'Europe'],
            'be_gdpr'    => ['name' => 'Belgium / GDPR + Data Protection Act', 'region' => 'Europe'],
            'dk_gdpr'    => ['name' => 'Denmark / GDPR + Data Protection Act', 'region' => 'Europe'],
            'se_gdpr'    => ['name' => 'Sweden / GDPR + Data Protection Act', 'region' => 'Europe'],
            'fi_gdpr'    => ['name' => 'Finland / GDPR + Data Protection Act', 'region' => 'Europe'],
            'no_gdpr'    => ['name' => 'Norway / GDPR + Personal Data Act', 'region' => 'Europe'],
            'is_gdpr'    => ['name' => 'Iceland / GDPR + Data Protection Act', 'region' => 'Europe'],
            'li_gdpr'    => ['name' => 'Liechtenstein / GDPR + Data Protection Act', 'region' => 'Europe'],
            'pl_gdpr'    => ['name' => 'Poland / GDPR + Data Protection Act', 'region' => 'Europe'],
            'cz_gdpr'    => ['name' => 'Czech Republic / GDPR',            'region' => 'Europe'],
            'pt_gdpr'    => ['name' => 'Portugal / GDPR + Law 58/2019',    'region' => 'Europe'],
            'gr_gdpr'    => ['name' => 'Greece / GDPR + Law 4624/2019',    'region' => 'Europe'],
            'ro_gdpr'    => ['name' => 'Romania / GDPR + Law 190/2018',    'region' => 'Europe'],
            'hu_gdpr'    => ['name' => 'Hungary / GDPR + Info Act',        'region' => 'Europe'],
            'hr_gdpr'    => ['name' => 'Croatia / GDPR',                   'region' => 'Europe'],
            'bg_gdpr'    => ['name' => 'Bulgaria / GDPR',                  'region' => 'Europe'],
            'ee_gdpr'    => ['name' => 'Estonia / GDPR',                   'region' => 'Europe'],
            'lv_gdpr'    => ['name' => 'Latvia / GDPR',                    'region' => 'Europe'],
            'lt_gdpr'    => ['name' => 'Lithuania / GDPR',                 'region' => 'Europe'],
            'lu_gdpr'    => ['name' => 'Luxembourg / GDPR',                'region' => 'Europe'],
            'mt_gdpr'    => ['name' => 'Malta / GDPR',                     'region' => 'Europe'],
            'cy_gdpr'    => ['name' => 'Cyprus / GDPR',                    'region' => 'Europe'],
            'sk_gdpr'    => ['name' => 'Slovakia / GDPR',                  'region' => 'Europe'],
            'si_gdpr'    => ['name' => 'Slovenia / GDPR',                  'region' => 'Europe'],
            'ua_pdpl'    => ['name' => 'Ukraine / Personal Data Protection Law', 'region' => 'Europe'],
            'rs_pdpl'    => ['name' => 'Serbia / Personal Data Protection Law', 'region' => 'Europe'],
            'tr_kvkk'    => ['name' => 'Turkey / KVKK',                    'region' => 'Europe'],
            'ru_152fz'   => ['name' => 'Russia / Federal Law 152-FZ',      'region' => 'Europe'],
            'us_ccpa'    => ['name' => 'US / CCPA (California)',           'region' => 'Americas'],
            'us_coppa'   => ['name' => 'US / COPPA (Children)',            'region' => 'Americas'],
            'us_va_cdpa'  => ['name' => 'US / Virginia CDPA',               'region' => 'Americas'],
            'us_co_cpa'   => ['name' => 'US / Colorado CPA',                'region' => 'Americas'],
            'us_ct_ctdpa' => ['name' => 'US / Connecticut CTDPA',           'region' => 'Americas'],
            'us_ut_ucpa'  => ['name' => 'US / Utah UCPA',                   'region' => 'Americas'],
            'us_or_ocpa'  => ['name' => 'US / Oregon OCPA',                 'region' => 'Americas'],
            'us_tx_tdpsa' => ['name' => 'US / Texas TDPSA',                 'region' => 'Americas'],
            'us_mt_mcdpa' => ['name' => 'US / Montana MCDPA',               'region' => 'Americas'],
            'us_de_dpdpa' => ['name' => 'US / Delaware DPDPA',              'region' => 'Americas'],
            'us_ia_icdpa' => ['name' => 'US / Iowa ICDPA',                  'region' => 'Americas'],
            'us_ne_dpa'   => ['name' => 'US / Nebraska Data Privacy Act',   'region' => 'Americas'],
            'us_nh_dpa'   => ['name' => 'US / New Hampshire Privacy Act',   'region' => 'Americas'],
            'us_nj_dpa'   => ['name' => 'US / New Jersey Data Privacy Act', 'region' => 'Americas'],
            'us_tn_tipa'  => ['name' => 'US / Tennessee TIPA',              'region' => 'Americas'],
            'us_mn_mcdpa' => ['name' => 'US / Minnesota MCDPA',             'region' => 'Americas'],
            'us_md_odpa'  => ['name' => 'US / Maryland ODPA',               'region' => 'Americas'],
            'us_in_cdpa'  => ['name' => 'US / Indiana CDPA',                'region' => 'Americas'],
            'us_ky_cdpa'  => ['name' => 'US / Kentucky CDPA',               'region' => 'Americas'],
            'us_ri_dpa'   => ['name' => 'US / Rhode Island Data Privacy Act', 'region' => 'Americas'],
            'ca_pipeda'  => ['name' => 'Canada / PIPEDA',                  'region' => 'Americas'],
            'au_privacy' => ['name' => 'Australia / Privacy Act',          'region' => 'Asia-Pacific'],
            'br_lgpd'    => ['name' => 'Brazil / LGPD',                    'region' => 'Americas'],
            'mx_lfpdppp'  => ['name' => 'Mexico / LFPDPPP',                 'region' => 'Americas'],
            'ar_pdpa'     => ['name' => 'Argentina / Personal Data Protection Law', 'region' => 'Americas'],
            'cl_law19628' => ['name' => 'Chile / Law 19.628',               'region' => 'Americas'],
            'co_habeas'   => ['name' => 'Colombia / Habeas Data Law',       'region' => 'Americas'],
            'pe_pdpl'     => ['name' => 'Peru / Personal Data Protection Law', 'region' => 'Americas'],
            'uy_pdpl'     => ['name' => 'Uruguay / Personal Data Protection Law', 'region' => 'Americas'],
            'jp_appi'    => ['name' => 'Japan / APPI',                     'region' => 'Asia-Pacific'],
            'kr_pipa'    => ['name' => 'South Korea / PIPA',               'region' => 'Asia-Pacific'],
            'cn_pipl'    => ['name' => 'China / PIPL',                     'region' => 'Asia-Pacific'],
            'in_dpdp'    => ['name' => 'India / DPDP Act',                 'region' => 'Asia-Pacific'],
            'sg_pdpa'    => ['name' => 'Singapore / PDPA',                 'region' => 'Asia-Pacific'],
            'th_pdpa'    => ['name' => 'Thailand / PDPA',                  'region' => 'Asia-Pacific'],
            'id_pdp'     => ['name' => 'Indonesia / PDP Law',              'region' => 'Asia-Pacific'],
            'my_pdpa'    => ['name' => 'Malaysia / PDPA',                  'region' => 'Asia-Pacific'],
            'ph_dpa'     => ['name' => 'Philippines / Data Privacy Act',   'region' => 'Asia-Pacific'],
            'vn_pdpd'     => ['name' => 'Vietnam / Personal Data Protection Decree', 'region' => 'Asia-Pacific'],
            'tw_pdpa'     => ['name' => 'Taiwan / Personal Data Protection Act', 'region' => 'Asia-Pacific'],
            'hk_pdpo'     => ['name' => 'Hong Kong / PDPO',                 'region' => 'Asia-Pacific'],
            'nz_privacy'  => ['name' => 'New Zealand / Privacy Act',        'region' => 'Asia-Pacific'],
            'ae_pdpl'    => ['name' => 'UAE / PDPL',                       'region' => 'Middle East & Africa'],
            'sa_pdpl'    => ['name' => 'Saudi Arabia / PDPL',              'region' => 'Middle East & Africa'],
            'qa_pdppl'   => ['name' => 'Qatar / PDPPL',                    'region' => 'Middle East & Africa'],
            'bh_pdpl'    => ['name' => 'Bahrain / PDPL',                   'region' => 'Middle East & Africa'],
            'eg_dpl'     => ['name' => 'Egypt / Data Protection Law',      'region' => 'Middle East & Africa'],
            'ma_law0908' => ['name' => 'Morocco / Law 09-08',              'region' => 'Middle East & Africa'],
            'il_pppl'     => ['name' => 'Israel / Protection of Privacy Law', 'region' => 'Middle East & Africa'],
            'za_popia'    => ['name' => 'South Africa / POPIA',             'region' => 'Middle East & Africa'],
            'ke_dpa'      => ['name' => 'Kenya / Data Protection Act',      'region' => 'Middle East & Africa'],
            'ng_ndpa'     => ['name' => 'Nigeria / Data Protection Act',    'region' => 'Middle East & Africa'],
            'rw_dpp'      => ['name' => 'Rwanda / Data Protection Law',     'region' => 'Middle East & Africa'],
            'gh_dpa'      => ['name' => 'Ghana / Data Protection Act',      'region' => 'Middle East & Africa'],
            'generic'    => ['name' => 'Generic / International',          'region' => 'Global'],
        ];
    }

    /**
     * Document types
     * required = always generated for this jurisdiction
     * optional = user can choose to include
     */
    public static function getDocumentTypes(): array {
        return [
            'privacy-policy'             => ['label' => 'Privacy Policy',              'slug' => 'privacy-policy'],
            'cookie-policy'              => ['label' => 'Cookie Policy',               'slug' => 'cookie-policy'],
            'terms-of-use'               => ['label' => 'Terms of Use',                'slug' => 'terms-of-use'],
            'data-processing-agreement'  => ['label' => 'Data Processing Agreement',   'slug' => 'data-processing-agreement'],
            'ccpa-notice'                => ['label' => 'CCPA Notice at Collection',   'slug' => 'ccpa-notice'],
            'refund-policy'              => ['label' => 'Refund Policy',               'slug' => 'refund-policy'],
            'disclaimer'                 => ['label' => 'Disclaimer',                  'slug' => 'disclaimer'],
        ];
    }

    /**
     * Which documents each jurisdiction requires or supports
     * 'required' = always generated
     * 'optional' = user can choose
     */
    public static function getJurisdictionDocuments(): array {
        $optional = ['refund-policy', 'disclaimer'];
        $gdprFull = [
            'required' => ['privacy-policy', 'cookie-policy', 'terms-of-use', 'data-processing-agreement'],
            'optional' => $optional,
        ];
        $europeBasic = [
            'required' => ['privacy-policy', 'cookie-policy', 'terms-of-use'],
            'optional' => $optional,
        ];
        $privacyBasic = [
            'required' => ['privacy-policy', 'terms-of-use'],
            'optional' => array_merge(['cookie-policy'], $optional),
        ];

        return [
            'eu_gdpr' => [
                'required' => ['privacy-policy', 'cookie-policy', 'terms-of-use', 'data-processing-agreement'],
                'optional' => $optional,
            ],
            'uk_gdpr' => [
                'required' => ['privacy-policy', 'cookie-policy', 'terms-of-use', 'data-processing-agreement'],
                'optional' => $optional,
            ],
            'eea_gdpr' => $gdprFull,
            'ch_fadp' => $europeBasic,
            'de_gdpr' => $gdprFull,
            'fr_gdpr' => $gdprFull,
            'es_gdpr' => $gdprFull,
            'it_gdpr' => $gdprFull,
            'nl_gdpr' => $gdprFull,
            'ie_gdpr' => $gdprFull,
            'at_gdpr' => $gdprFull,
            'be_gdpr' => $gdprFull,
            'dk_gdpr' => $gdprFull,
            'se_gdpr' => $gdprFull,
            'fi_gdpr' => $gdprFull,
            'no_gdpr' => $gdprFull,
            'is_gdpr' => $gdprFull,
            'li_gdpr' => $gdprFull,
            'pl_gdpr' => $gdprFull,
            'cz_gdpr' => $gdprFull,
            'pt_gdpr' => $gdprFull,
            'gr_gdpr' => $gdprFull,
            'ro_gdpr' => $gdprFull,
            'hu_gdpr' => $gdprFull,
            'hr_gdpr' => $gdprFull,
            'bg_gdpr' => $gdprFull,
            'ee_gdpr' => $gdprFull,
            'lv_gdpr' => $gdprFull,
            'lt_gdpr' => $gdprFull,
            'lu_gdpr' => $gdprFull,
            'mt_gdpr' => $gdprFull,
            'cy_gdpr' => $gdprFull,
            'sk_gdpr' => $gdprFull,
            'si_gdpr' => $gdprFull,
            'ua_pdpl' => $europeBasic,
            'rs_pdpl' => $europeBasic,
            'tr_kvkk' => $europeBasic,
            'ru_152fz' => $europeBasic,
            'us_ccpa' => [
                'required' => ['privacy-policy', 'terms-of-use', 'ccpa-notice'],
                'optional' => $optional,
            ],
            'us_coppa' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'us_va_cdpa' => $privacyBasic,
            'us_co_cpa' => $privacyBasic,
            'us_ct_ctdpa' => $privacyBasic,
            'us_ut_ucpa' => $privacyBasic,
            'us_or_ocpa' => $privacyBasic,
            'us_tx_tdpsa' => $privacyBasic,
            'us_mt_mcdpa' => $privacyBasic,
            'us_de_dpdpa' => $privacyBasic,
            'us_ia_icdpa' => $privacyBasic,
            'us_ne_dpa' => $privacyBasic,
            'us_nh_dpa' => $privacyBasic,
            'us_nj_dpa' => $privacyBasic,
            'us_tn_tipa' => $privacyBasic,
            'us_mn_mcdpa' => $privacyBasic,
            'us_md_odpa' => $privacyBasic,
            'us_in_cdpa' => $privacyBasic,
            'us_ky_cdpa' => $privacyBasic,
            'us_ri_dpa' => $privacyBasic,
            'ca_pipeda' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'au_privacy' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'br_lgpd' => [
                'required' => ['privacy-policy', 'cookie-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'mx_lfpdppp' => $privacyBasic,
            'ar_pdpa' => $privacyBasic,
            'cl_law19628' => $privacyBasic,
            'co_habeas' => $privacyBasic,
            'pe_pdpl' => $privacyBasic,
            'uy_pdpl' => $privacyBasic,
            'jp_appi' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'kr_pipa' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'cn_pipl' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'in_dpdp' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'sg_pdpa' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'th_pdpa' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'id_pdp' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'my_pdpa' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'ph_dpa' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'vn_pdpd' => $privacyBasic,
            'tw_pdpa' => $privacyBasic,
            'hk_pdpo' => $privacyBasic,
            'nz_privacy' => $privacyBasic,
            'ae_pdpl' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'sa_pdpl' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'qa_pdppl' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'bh_pdpl' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'eg_dpl' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'ma_law0908' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => $optional,
            ],
            'il_pppl' => $privacyBasic,
            'za_popia' => $privacyBasic,
            'ke_dpa' => $privacyBasic,
            'ng_ndpa' => $privacyBasic,
            'rw_dpp' => $privacyBasic,
            'gh_dpa' => $privacyBasic,
            'generic' => [
                'required' => ['privacy-policy', 'terms-of-use'],
                'optional' => array_merge(['cookie-policy'], $optional),
            ],
        ];
    }

    /**
     * Supported languages
     */
    public static function getLanguages(): array {
        return [
            'en' => 'English',
            'de' => 'German',
            'fr' => 'French',
            'es' => 'Spanish',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'nl' => 'Dutch',
            'pl' => 'Polish',
            'cs' => 'Czech',
            'da' => 'Danish',
            'sv' => 'Swedish',
            'fi' => 'Finnish',
            'no' => 'Norwegian',
            'is' => 'Icelandic',
            'el' => 'Greek',
            'ro' => 'Romanian',
            'hu' => 'Hungarian',
            'hr' => 'Croatian',
            'bg' => 'Bulgarian',
            'et' => 'Estonian',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'sr' => 'Serbian',
            'tr' => 'Turkish',
            'ru' => 'Russian',
            'uk' => 'Ukrainian',
            'ja' => 'Japanese',
            'zh' => 'Chinese (Simplified)',
            'zh-hant' => 'Chinese (Traditional)',
            'hi' => 'Hindi',
            'ar' => 'Arabic',
            'he' => 'Hebrew',
            'ko' => 'Korean',
            'th' => 'Thai',
            'ta' => 'Tamil',
            'id' => 'Indonesian',
            'ms' => 'Malay',
            'vi' => 'Vietnamese',
            'fil' => 'Filipino',
            'af' => 'Afrikaans',
            'sw' => 'Swahili',
            'rw' => 'Kinyarwanda',
        ];
    }

    /**
     * Recommended languages per jurisdiction.
     * English is included broadly as a practical fallback for international sites.
     */
    public static function getJurisdictionLanguages(): array {
        $us = ['en', 'es'];
        $eu = ['en', 'de', 'fr', 'es', 'it', 'pt', 'nl', 'pl'];

        return [
            'eu_gdpr' => $eu,
            'uk_gdpr' => ['en'],
            'eea_gdpr' => array_merge($eu, ['no', 'is']),
            'ch_fadp' => ['en', 'de', 'fr', 'it'],
            'de_gdpr' => ['de', 'en'],
            'fr_gdpr' => ['fr', 'en'],
            'es_gdpr' => ['es', 'en'],
            'it_gdpr' => ['it', 'en'],
            'nl_gdpr' => ['nl', 'en'],
            'ie_gdpr' => ['en'],
            'at_gdpr' => ['de', 'en'],
            'be_gdpr' => ['nl', 'fr', 'de', 'en'],
            'dk_gdpr' => ['da', 'en'],
            'se_gdpr' => ['sv', 'en'],
            'fi_gdpr' => ['fi', 'sv', 'en'],
            'no_gdpr' => ['no', 'en'],
            'is_gdpr' => ['is', 'en'],
            'li_gdpr' => ['de', 'en'],
            'pl_gdpr' => ['pl', 'en'],
            'cz_gdpr' => ['cs', 'en'],
            'pt_gdpr' => ['pt', 'en'],
            'gr_gdpr' => ['el', 'en'],
            'ro_gdpr' => ['ro', 'en'],
            'hu_gdpr' => ['hu', 'en'],
            'hr_gdpr' => ['hr', 'en'],
            'bg_gdpr' => ['bg', 'en'],
            'ee_gdpr' => ['et', 'en'],
            'lv_gdpr' => ['lv', 'en'],
            'lt_gdpr' => ['lt', 'en'],
            'lu_gdpr' => ['fr', 'de', 'en'],
            'mt_gdpr' => ['en'],
            'cy_gdpr' => ['el', 'en'],
            'sk_gdpr' => ['sk', 'en'],
            'si_gdpr' => ['sl', 'en'],
            'ua_pdpl' => ['uk', 'ru', 'en'],
            'rs_pdpl' => ['sr', 'en'],
            'tr_kvkk' => ['tr', 'en'],
            'ru_152fz' => ['ru', 'en'],
            'us_ccpa' => $us,
            'us_coppa' => $us,
            'us_va_cdpa' => $us,
            'us_co_cpa' => $us,
            'us_ct_ctdpa' => $us,
            'us_ut_ucpa' => $us,
            'us_or_ocpa' => $us,
            'us_tx_tdpsa' => $us,
            'us_mt_mcdpa' => $us,
            'us_de_dpdpa' => $us,
            'us_ia_icdpa' => $us,
            'us_ne_dpa' => $us,
            'us_nh_dpa' => $us,
            'us_nj_dpa' => $us,
            'us_tn_tipa' => $us,
            'us_mn_mcdpa' => $us,
            'us_md_odpa' => $us,
            'us_in_cdpa' => $us,
            'us_ky_cdpa' => $us,
            'us_ri_dpa' => $us,
            'ca_pipeda' => ['en', 'fr'],
            'br_lgpd' => ['pt', 'en'],
            'mx_lfpdppp' => ['es', 'en'],
            'ar_pdpa' => ['es', 'en'],
            'cl_law19628' => ['es', 'en'],
            'co_habeas' => ['es', 'en'],
            'pe_pdpl' => ['es', 'en'],
            'uy_pdpl' => ['es', 'en'],
            'au_privacy' => ['en'],
            'jp_appi' => ['ja', 'en'],
            'kr_pipa' => ['ko', 'en'],
            'cn_pipl' => ['zh', 'en'],
            'in_dpdp' => ['en', 'hi'],
            'sg_pdpa' => ['en', 'zh', 'ms', 'ta'],
            'th_pdpa' => ['th', 'en'],
            'id_pdp' => ['id', 'en'],
            'my_pdpa' => ['ms', 'en', 'zh'],
            'ph_dpa' => ['fil', 'en'],
            'vn_pdpd' => ['vi', 'en'],
            'tw_pdpa' => ['zh-hant', 'en'],
            'hk_pdpo' => ['zh-hant', 'en'],
            'nz_privacy' => ['en'],
            'ae_pdpl' => ['ar', 'en'],
            'sa_pdpl' => ['ar', 'en'],
            'qa_pdppl' => ['ar', 'en'],
            'bh_pdpl' => ['ar', 'en'],
            'eg_dpl' => ['ar', 'en'],
            'ma_law0908' => ['ar', 'fr', 'en'],
            'il_pppl' => ['he', 'en', 'ar'],
            'za_popia' => ['en', 'af'],
            'ke_dpa' => ['en', 'sw'],
            'ng_ndpa' => ['en'],
            'rw_dpp' => ['rw', 'en', 'fr'],
            'gh_dpa' => ['en'],
            'generic' => array_keys(self::getLanguages()),
        ];
    }

    /**
     * Jurisdiction-specific legal requirements for AI prompts
     */
    public static function getJurisdictionRequirements(): array {
        $gdprRequirements = [
            'Identify lawful basis for processing under GDPR Article 6',
            'List data subject rights: access, rectification, erasure, portability, objection, restriction',
            'Mention Data Protection Officer where required',
            'State retention periods and security measures',
            'Explain international transfers outside the EEA and safeguards',
            'Include cookie/ePrivacy consent requirements where applicable',
            'Name the local supervisory authority for complaints',
        ];
        $usStateRequirements = [
            'List categories of personal data processed and purposes',
            'Explain consumer rights: access, correction where applicable, deletion, portability, opt-out',
            'Describe opt-out rights for targeted advertising, sale of personal data, and profiling where applicable',
            'Explain sensitive data consent or opt-out requirements where applicable',
            'State appeal process for denied consumer requests where required',
            'Explain response timelines and controller contact method',
        ];

        return [
            'eu_gdpr' => [
                'law' => 'EU General Data Protection Regulation (GDPR) 2016/679',
                'requirements' => [
                    'Identify lawful basis for processing (Art. 6)',
                    'List data subject rights: access, rectification, erasure, portability, objection (Art. 15-21)',
                    'Mention Data Protection Officer if applicable',
                    'State data retention periods',
                    'List third-party processors and data transfers outside EEA',
                    'Cookie consent requirements (ePrivacy Directive)',
                    'Right to lodge complaint with supervisory authority',
                ],
            ],
            'uk_gdpr' => [
                'law' => 'UK GDPR and Data Protection Act 2018',
                'requirements' => [
                    'Same as EU GDPR but reference UK ICO as supervisory authority',
                    'Post-Brexit data transfer mechanisms',
                    'UK adequacy decisions',
                ],
            ],
            'eea_gdpr' => [
                'law' => 'General Data Protection Regulation as applied in the European Economic Area (EU + Iceland, Liechtenstein, Norway)',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference EEA scope and EFTA/EEA supervisory authorities where relevant',
                    'Explain EEA transfer rules and safeguards for third countries',
                ]),
            ],
            'ch_fadp' => [
                'law' => 'Swiss Federal Act on Data Protection (FADP), in force from 1 September 2023',
                'requirements' => [
                    'Explain processing purposes and categories of personal data',
                    'Address data subject information rights under the FADP',
                    'Mention high-risk profiling and automated decision-making where relevant',
                    'Explain international data transfers and safeguards',
                    'Reference the Federal Data Protection and Information Commissioner (FDPIC)',
                ],
            ],
            'de_gdpr' => [
                'law' => 'GDPR, German Federal Data Protection Act (BDSG), and Telecommunications-Telemedia Data Protection Act (TTDSG)',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference BDSG where employment or special processing applies',
                    'Address TTDSG/ePrivacy cookie and tracking consent requirements',
                    'Mention competent German federal or state supervisory authority',
                ]),
            ],
            'fr_gdpr' => [
                'law' => 'GDPR and French Data Protection Act (Loi Informatique et Libertes)',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference CNIL guidance for cookies and trackers',
                    'Mention CNIL as supervisory authority',
                ]),
            ],
            'es_gdpr' => [
                'law' => 'GDPR and Spanish Organic Law 3/2018 (LOPDGDD)',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference LOPDGDD where Spanish-specific rights or digital rights apply',
                    'Mention AEPD as supervisory authority',
                ]),
            ],
            'it_gdpr' => [
                'law' => 'GDPR and Italian Privacy Code (Codice in materia di protezione dei dati personali)',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference Italian Privacy Code and Garante guidance',
                    'Mention Garante per la protezione dei dati personali as supervisory authority',
                ]),
            ],
            'nl_gdpr' => [
                'law' => 'GDPR and Dutch GDPR Implementation Act (UAVG)',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference UAVG where local implementation rules apply',
                    'Mention Autoriteit Persoonsgegevens as supervisory authority',
                ]),
            ],
            'ie_gdpr' => [
                'law' => 'GDPR and Irish Data Protection Act 2018',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference Ireland as potential EU establishment for cross-border processing where applicable',
                    'Mention Data Protection Commission (DPC) as supervisory authority',
                ]),
            ],
            'at_gdpr' => [
                'law' => 'GDPR and Austrian Data Protection Act (DSG)',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Datenschutzbehorde (DSB) as supervisory authority',
                ]),
            ],
            'be_gdpr' => [
                'law' => 'GDPR and Belgian Data Protection Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Belgian Data Protection Authority (APD/GBA) as supervisory authority',
                ]),
            ],
            'dk_gdpr' => [
                'law' => 'GDPR and Danish Data Protection Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Datatilsynet as supervisory authority',
                ]),
            ],
            'se_gdpr' => [
                'law' => 'GDPR and Swedish Data Protection Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Integritetsskyddsmyndigheten (IMY) as supervisory authority',
                ]),
            ],
            'fi_gdpr' => [
                'law' => 'GDPR and Finnish Data Protection Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Office of the Data Protection Ombudsman as supervisory authority',
                ]),
            ],
            'no_gdpr' => [
                'law' => 'GDPR as implemented in Norway and the Norwegian Personal Data Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference Norway as an EEA/EFTA GDPR jurisdiction',
                    'Mention Datatilsynet Norway as supervisory authority',
                ]),
            ],
            'is_gdpr' => [
                'law' => 'GDPR as implemented in Iceland and Icelandic data protection law',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference Iceland as an EEA/EFTA GDPR jurisdiction',
                    'Mention Persónuvernd as supervisory authority',
                ]),
            ],
            'li_gdpr' => [
                'law' => 'GDPR as implemented in Liechtenstein and Liechtenstein data protection law',
                'requirements' => array_merge($gdprRequirements, [
                    'Reference Liechtenstein as an EEA/EFTA GDPR jurisdiction',
                    'Mention Datenschutzstelle Liechtenstein as supervisory authority',
                ]),
            ],
            'pl_gdpr' => [
                'law' => 'GDPR and Polish Data Protection Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention UODO as supervisory authority',
                ]),
            ],
            'cz_gdpr' => [
                'law' => 'GDPR and Czech data protection law',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention UOOU as supervisory authority',
                ]),
            ],
            'pt_gdpr' => [
                'law' => 'GDPR and Portuguese Law 58/2019',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention CNPD Portugal as supervisory authority',
                ]),
            ],
            'gr_gdpr' => [
                'law' => 'GDPR and Greek Law 4624/2019',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Hellenic Data Protection Authority as supervisory authority',
                ]),
            ],
            'ro_gdpr' => [
                'law' => 'GDPR and Romanian Law 190/2018',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention ANSPDCP as supervisory authority',
                ]),
            ],
            'hu_gdpr' => [
                'law' => 'GDPR and Hungarian Information Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention NAIH as supervisory authority',
                ]),
            ],
            'hr_gdpr' => [
                'law' => 'GDPR and Croatian data protection law',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention AZOP as supervisory authority',
                ]),
            ],
            'bg_gdpr' => [
                'law' => 'GDPR and Bulgarian Personal Data Protection Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention CPDP Bulgaria as supervisory authority',
                ]),
            ],
            'ee_gdpr' => [
                'law' => 'GDPR and Estonian Personal Data Protection Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Andmekaitse Inspektsioon as supervisory authority',
                ]),
            ],
            'lv_gdpr' => [
                'law' => 'GDPR and Latvian Personal Data Processing Law',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Data State Inspectorate of Latvia as supervisory authority',
                ]),
            ],
            'lt_gdpr' => [
                'law' => 'GDPR and Lithuanian Law on Legal Protection of Personal Data',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention State Data Protection Inspectorate as supervisory authority',
                ]),
            ],
            'lu_gdpr' => [
                'law' => 'GDPR and Luxembourg data protection law',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention CNPD Luxembourg as supervisory authority',
                ]),
            ],
            'mt_gdpr' => [
                'law' => 'GDPR and Maltese Data Protection Act',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention IDPC Malta as supervisory authority',
                ]),
            ],
            'cy_gdpr' => [
                'law' => 'GDPR and Cyprus data protection law',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Commissioner for Personal Data Protection of Cyprus as supervisory authority',
                ]),
            ],
            'sk_gdpr' => [
                'law' => 'GDPR and Slovak data protection law',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Office for Personal Data Protection of the Slovak Republic as supervisory authority',
                ]),
            ],
            'si_gdpr' => [
                'law' => 'GDPR and Slovenian data protection law',
                'requirements' => array_merge($gdprRequirements, [
                    'Mention Information Commissioner of Slovenia as supervisory authority',
                ]),
            ],
            'ua_pdpl' => [
                'law' => 'Ukraine Law on Personal Data Protection',
                'requirements' => [
                    'Explain personal data processing purposes and scope',
                    'Address consent and other lawful grounds for processing',
                    'List data subject rights, including access, correction, and withdrawal of consent',
                    'Explain cross-border transfer safeguards where applicable',
                    'Mention the Ukrainian Parliament Commissioner for Human Rights as supervisory authority',
                ],
            ],
            'rs_pdpl' => [
                'law' => 'Serbian Law on Personal Data Protection',
                'requirements' => [
                    'Use GDPR-like structure for lawful basis, transparency, and data subject rights',
                    'Explain controller and processor roles',
                    'Address international transfers and safeguards',
                    'Mention the Commissioner for Information of Public Importance and Personal Data Protection',
                ],
            ],
            'tr_kvkk' => [
                'law' => 'Turkish Personal Data Protection Law No. 6698 (KVKK)',
                'requirements' => [
                    'Explain explicit consent and other processing conditions under KVKK',
                    'Address special categories of personal data',
                    'List data subject rights under Article 11',
                    'Explain domestic and international data transfers',
                    'Mention the Turkish Personal Data Protection Authority (KVKK Authority)',
                ],
            ],
            'ru_152fz' => [
                'law' => 'Russian Federal Law No. 152-FZ on Personal Data',
                'requirements' => [
                    'Explain purposes, categories, and methods of personal data processing',
                    'Address consent requirements and data subject rights',
                    'Mention Russian data localization requirements where applicable',
                    'Explain cross-border transfer restrictions and safeguards',
                    'Mention Roskomnadzor as supervisory authority',
                ],
            ],
            'us_ccpa' => [
                'law' => 'California Consumer Privacy Act (CCPA) / CPRA',
                'requirements' => [
                    'Categories of personal information collected',
                    'Right to know, delete, opt-out of sale, non-discrimination',
                    'Do Not Sell or Share My Personal Information link',
                    'Financial incentives disclosure',
                    'Response timeline: 45 days',
                ],
            ],
            'us_coppa' => [
                'law' => 'Children\'s Online Privacy Protection Act (COPPA)',
                'requirements' => [
                    'Parental consent requirements for children under 13',
                    'Types of information collected from children',
                    'How parents can review/delete child data',
                    'No behavioral advertising to children',
                ],
            ],
            'us_va_cdpa' => [
                'law' => 'Virginia Consumer Data Protection Act (VCDPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Virginia-specific consumer rights and controller obligations',
                    'Mention opt-in consent for sensitive data',
                ]),
            ],
            'us_co_cpa' => [
                'law' => 'Colorado Privacy Act (CPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Colorado universal opt-out mechanism requirements where applicable',
                    'Mention Colorado Attorney General enforcement',
                ]),
            ],
            'us_ct_ctdpa' => [
                'law' => 'Connecticut Data Privacy Act (CTDPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Connecticut consumer rights and opt-out obligations',
                    'Mention Connecticut Attorney General enforcement',
                ]),
            ],
            'us_ut_ucpa' => [
                'law' => 'Utah Consumer Privacy Act (UCPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Utah consumer rights and controller obligations',
                    'Note Utah-specific treatment of sensitive data where applicable',
                ]),
            ],
            'us_or_ocpa' => [
                'law' => 'Oregon Consumer Privacy Act (OCPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Oregon consumer rights and opt-out obligations',
                    'Mention Oregon Attorney General enforcement',
                ]),
            ],
            'us_tx_tdpsa' => [
                'law' => 'Texas Data Privacy and Security Act (TDPSA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Texas applicability and consumer request process',
                    'Mention Texas Attorney General enforcement',
                ]),
            ],
            'us_mt_mcdpa' => [
                'law' => 'Montana Consumer Data Privacy Act (MCDPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Montana consumer rights and opt-out obligations',
                ]),
            ],
            'us_de_dpdpa' => [
                'law' => 'Delaware Personal Data Privacy Act (DPDPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Delaware consumer rights and sensitive data treatment',
                ]),
            ],
            'us_ia_icdpa' => [
                'law' => 'Iowa Consumer Data Protection Act (ICDPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Iowa consumer rights and controller notice obligations',
                ]),
            ],
            'us_ne_dpa' => [
                'law' => 'Nebraska Data Privacy Act',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Nebraska consumer rights and privacy notice requirements',
                ]),
            ],
            'us_nh_dpa' => [
                'law' => 'New Hampshire Data Privacy Act',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference New Hampshire consumer rights and appeal process',
                ]),
            ],
            'us_nj_dpa' => [
                'law' => 'New Jersey Data Privacy Act',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference New Jersey consumer rights and sensitive data requirements',
                ]),
            ],
            'us_tn_tipa' => [
                'law' => 'Tennessee Information Protection Act (TIPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Tennessee privacy notice and consumer rights requirements',
                ]),
            ],
            'us_mn_mcdpa' => [
                'law' => 'Minnesota Consumer Data Privacy Act (MCDPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Minnesota consumer rights and profiling transparency where applicable',
                ]),
            ],
            'us_md_odpa' => [
                'law' => 'Maryland Online Data Privacy Act (MODPA)',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Maryland data minimization and sensitive data restrictions where applicable',
                ]),
            ],
            'us_in_cdpa' => [
                'law' => 'Indiana Consumer Data Protection Act',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Indiana consumer rights and controller obligations',
                ]),
            ],
            'us_ky_cdpa' => [
                'law' => 'Kentucky Consumer Data Protection Act',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Kentucky consumer rights and opt-out obligations',
                ]),
            ],
            'us_ri_dpa' => [
                'law' => 'Rhode Island Data Transparency and Privacy Protection Act',
                'requirements' => array_merge($usStateRequirements, [
                    'Reference Rhode Island transparency and consumer request requirements',
                ]),
            ],
            'ca_pipeda' => [
                'law' => 'Personal Information Protection and Electronic Documents Act (PIPEDA)',
                'requirements' => [
                    'Ten fair information principles',
                    'Consent for collection, use, disclosure',
                    'Access and correction rights',
                    'Privacy officer contact',
                ],
            ],
            'au_privacy' => [
                'law' => 'Privacy Act 1988 (Australia) — Australian Privacy Principles (APPs)',
                'requirements' => [
                    '13 Australian Privacy Principles',
                    'Notifiable data breaches scheme',
                    'Cross-border disclosure',
                    'Access and correction rights',
                ],
            ],
            'br_lgpd' => [
                'law' => 'Lei Geral de Proteção de Dados (LGPD) — Law 13.709/2018',
                'requirements' => [
                    'Legal basis for processing (10 bases under Art. 7)',
                    'Data subject rights (Art. 18)',
                    'Data Protection Officer (Encarregado)',
                    'ANPD as supervisory authority',
                    'International data transfers',
                ],
            ],
            'mx_lfpdppp' => [
                'law' => 'Federal Law on Protection of Personal Data Held by Private Parties (LFPDPPP) — Mexico',
                'requirements' => [
                    'Explain privacy notice requirements and data controller identity',
                    'Describe ARCO rights: access, rectification, cancellation, objection',
                    'Address consent, sensitive data, transfers, and revocation of consent',
                    'Mention INAI as supervisory authority',
                ],
            ],
            'ar_pdpa' => [
                'law' => 'Argentina Personal Data Protection Law No. 25,326',
                'requirements' => [
                    'Explain database registration or controller obligations where applicable',
                    'Describe access, rectification, update, suppression, and confidentiality rights',
                    'Address consent and international transfer restrictions',
                    'Mention AAIP as supervisory authority',
                ],
            ],
            'cl_law19628' => [
                'law' => 'Chile Law No. 19,628 on Protection of Private Life',
                'requirements' => [
                    'Explain processing purposes and consent basis',
                    'Describe rights of access, rectification, cancellation, and objection',
                    'Address data transfers and contact process',
                ],
            ],
            'co_habeas' => [
                'law' => 'Colombia Habeas Data Law and Law 1581 of 2012',
                'requirements' => [
                    'Explain authorization for processing personal data',
                    'Describe habeas data rights and claims procedure',
                    'Address transfers/transmissions and processor duties',
                    'Mention SIC Colombia as supervisory authority',
                ],
            ],
            'pe_pdpl' => [
                'law' => 'Peru Personal Data Protection Law No. 29733',
                'requirements' => [
                    'Explain consent, data bank obligations, and processing purposes',
                    'Describe ARCO rights and request process',
                    'Address international transfers and security measures',
                    'Mention ANPD Peru as supervisory authority',
                ],
            ],
            'uy_pdpl' => [
                'law' => 'Uruguay Personal Data Protection Law No. 18,331',
                'requirements' => [
                    'Explain consent and database/controller obligations',
                    'Describe access, rectification, update, inclusion, and suppression rights',
                    'Address international transfer adequacy and safeguards',
                    'Mention URCDP as supervisory authority',
                ],
            ],
            'jp_appi' => [
                'law' => 'Act on the Protection of Personal Information (APPI) — 2022 amendment',
                'requirements' => [
                    'Purpose of use specification',
                    'Third-party provision restrictions',
                    'Cross-border transfer consent',
                    'Data subject rights: disclosure, correction, deletion',
                    'PPC as supervisory authority',
                ],
            ],
            'kr_pipa' => [
                'law' => 'Personal Information Protection Act (PIPA) — South Korea',
                'requirements' => [
                    'Consent for collection and use',
                    'Mandatory items: purpose, items collected, retention period',
                    'Data subject rights',
                    'Chief Privacy Officer appointment',
                    'PIPC as supervisory authority',
                ],
            ],
            'cn_pipl' => [
                'law' => 'Personal Information Protection Law (PIPL) — China 2021',
                'requirements' => [
                    'Separate consent for sensitive personal information',
                    'Data localization requirements',
                    'Cross-border transfer restrictions and security assessments',
                    'Automated decision-making transparency',
                    'CAC as supervisory authority',
                ],
            ],
            'in_dpdp' => [
                'law' => 'Digital Personal Data Protection Act (DPDP) 2023 — India',
                'requirements' => [
                    'Consent notice requirements',
                    'Data principal rights: access, correction, erasure, grievance redressal',
                    'Data fiduciary obligations',
                    'Cross-border transfer provisions',
                    'DPBI as supervisory authority',
                ],
            ],
            'sg_pdpa' => [
                'law' => 'Personal Data Protection Act (PDPA) 2012 — Singapore',
                'requirements' => [
                    'Consent, purpose limitation, notification obligations',
                    'Data portability right',
                    'Mandatory data breach notification',
                    'PDPC as supervisory authority',
                ],
            ],
            'th_pdpa' => [
                'law' => 'Personal Data Protection Act (PDPA) B.E. 2562 — Thailand',
                'requirements' => [
                    'Similar to GDPR structure',
                    'Lawful basis for processing',
                    'Data subject rights',
                    'PDPC Thailand as supervisory authority',
                ],
            ],
            'id_pdp' => [
                'law' => 'Personal Data Protection Law (PDP Law) 2022 — Indonesia',
                'requirements' => [
                    'Consent requirements',
                    'Data subject rights',
                    'Cross-border transfer provisions',
                    'Kominfo as supervisory authority',
                ],
            ],
            'my_pdpa' => [
                'law' => 'Personal Data Protection Act 2010 — Malaysia',
                'requirements' => [
                    'Seven data protection principles',
                    'Sensitive personal data special treatment',
                    'Transfer outside Malaysia restrictions',
                    'PDPD as supervisory authority',
                ],
            ],
            'ph_dpa' => [
                'law' => 'Data Privacy Act of 2012 (Republic Act 10173) — Philippines',
                'requirements' => [
                    'Data Privacy Principles',
                    'Data subject rights',
                    'Data Protection Officer requirement',
                    'NPC as supervisory authority',
                ],
            ],
            'vn_pdpd' => [
                'law' => 'Vietnam Personal Data Protection Decree (Decree 13/2023/ND-CP)',
                'requirements' => [
                    'Distinguish basic and sensitive personal data',
                    'Explain consent and data subject notification requirements',
                    'Address data subject rights and cross-border transfer requirements',
                    'Mention Vietnamese Ministry of Public Security where relevant',
                ],
            ],
            'tw_pdpa' => [
                'law' => 'Taiwan Personal Data Protection Act',
                'requirements' => [
                    'Explain collection notice requirements and specified purposes',
                    'Describe data subject rights: inquiry, review, copy, supplement, correction, deletion',
                    'Address international transfers and security measures',
                ],
            ],
            'hk_pdpo' => [
                'law' => 'Hong Kong Personal Data (Privacy) Ordinance (PDPO)',
                'requirements' => [
                    'Address the six Data Protection Principles',
                    'Explain direct marketing consent requirements where applicable',
                    'Describe access and correction rights',
                    'Mention PCPD as supervisory authority',
                ],
            ],
            'nz_privacy' => [
                'law' => 'New Zealand Privacy Act 2020',
                'requirements' => [
                    'Address Information Privacy Principles',
                    'Explain access and correction rights',
                    'Mention notifiable privacy breach requirements',
                    'Mention Office of the Privacy Commissioner as supervisory authority',
                ],
            ],
            'ae_pdpl' => [
                'law' => 'Federal Decree-Law No. 45/2021 on Personal Data Protection — UAE',
                'requirements' => [
                    'Consent and legitimate interest basis',
                    'Data subject rights',
                    'Cross-border transfer requirements',
                    'TDRA as supervisory authority',
                ],
            ],
            'sa_pdpl' => [
                'law' => 'Personal Data Protection Law (PDPL) — Saudi Arabia 2021',
                'requirements' => [
                    'Consent requirements',
                    'Sensitive data special categories',
                    'Data subject rights',
                    'SDAIA/NCA as supervisory authority',
                ],
            ],
            'qa_pdppl' => [
                'law' => 'Personal Data Privacy Protection Law — Qatar',
                'requirements' => [
                    'Consent and data minimization',
                    'Data subject rights',
                    'Cross-border transfer restrictions',
                ],
            ],
            'bh_pdpl' => [
                'law' => 'Personal Data Protection Law 2018 — Bahrain',
                'requirements' => [
                    'Data processing principles',
                    'Sensitive data categories',
                    'Data subject rights',
                    'PDPB as supervisory authority',
                ],
            ],
            'eg_dpl' => [
                'law' => 'Data Protection Law No. 151/2020 — Egypt',
                'requirements' => [
                    'Consent requirements',
                    'Data subject rights',
                    'Cross-border transfer approval',
                    'ITIDA as supervisory authority',
                ],
            ],
            'ma_law0908' => [
                'law' => 'Law No. 09-08 on Protection of Individuals — Morocco',
                'requirements' => [
                    'CNDP registration requirements',
                    'Consent for processing',
                    'Data subject rights',
                    'CNDP as supervisory authority',
                ],
            ],
            'il_pppl' => [
                'law' => 'Israel Protection of Privacy Law and Privacy Protection Regulations',
                'requirements' => [
                    'Explain database/controller obligations where applicable',
                    'Describe data subject access and correction rights',
                    'Address direct marketing and data security obligations',
                    'Mention the Privacy Protection Authority as supervisory authority',
                ],
            ],
            'za_popia' => [
                'law' => 'Protection of Personal Information Act (POPIA) — South Africa',
                'requirements' => [
                    'Address POPIA processing conditions and lawful basis',
                    'Explain data subject rights and information officer contact',
                    'Mention cross-border transfer requirements',
                    'Mention Information Regulator South Africa as supervisory authority',
                ],
            ],
            'ke_dpa' => [
                'law' => 'Kenya Data Protection Act 2019',
                'requirements' => [
                    'Explain lawful basis and data subject rights',
                    'Address data controller/processor registration where applicable',
                    'Mention cross-border transfer safeguards',
                    'Mention Office of the Data Protection Commissioner as supervisory authority',
                ],
            ],
            'ng_ndpa' => [
                'law' => 'Nigeria Data Protection Act 2023',
                'requirements' => [
                    'Explain lawful basis, transparency, and data subject rights',
                    'Address data controller/processor obligations',
                    'Mention cross-border transfer safeguards',
                    'Mention Nigeria Data Protection Commission as supervisory authority',
                ],
            ],
            'rw_dpp' => [
                'law' => 'Rwanda Law Relating to the Protection of Personal Data and Privacy',
                'requirements' => [
                    'Explain consent and lawful processing grounds',
                    'Describe data subject rights and controller obligations',
                    'Address registration and cross-border transfer requirements where applicable',
                    'Mention NCSA as supervisory authority where relevant',
                ],
            ],
            'gh_dpa' => [
                'law' => 'Ghana Data Protection Act 2012',
                'requirements' => [
                    'Explain data protection principles and processing purposes',
                    'Describe data subject rights and consent requirements',
                    'Address data controller registration where applicable',
                    'Mention Data Protection Commission Ghana as supervisory authority',
                ],
            ],
            'generic' => [
                'law' => 'International best practices (no specific jurisdiction)',
                'requirements' => [
                    'What data is collected and why',
                    'How data is used and stored',
                    'Third-party sharing',
                    'User rights and contact information',
                    'Cookie usage',
                    'Security measures',
                ],
            ],
        ];
    }
}
