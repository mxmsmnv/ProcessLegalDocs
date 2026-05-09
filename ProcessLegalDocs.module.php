<?php namespace ProcessWire;

/**
 * ProcessLegalDocs
 *
 * AI-powered legal document generator for ProcessWire.
 * Generates Privacy Policy, Terms of Use, Cookie Policy and more
 * for 93 jurisdictions in multiple languages.
 *
 * @author Maxim Alex
 * @license MIT
 */
class ProcessLegalDocs extends Process implements Module, ConfigurableModule {

    public static function getModuleInfo(): array {
        return [
            'title'    => 'Legal Docs',
            'version'  => 100,
            'summary'  => 'AI-powered legal document generator. Generates Privacy Policy, Terms of Use, Cookie Policy and more for 93 jurisdictions.',
            'author'   => 'Maxim Alex',
            'icon'     => 'file-text-o',
            'requires' => 'ProcessWire>=3.0.255, PHP>=8.3',
            'autoload' => false,
            'singular' => true,
            'page'     => [
                'name'   => 'legal-docs',
                'parent' => 'setup',
                'title'  => 'Legal Docs',
            ],
        ];
    }

    protected static $configDefaults = [
        'owner_type'                          => 'company',
        'owner_company_name'                  => '',
        'owner_first_name'                    => '',
        'owner_last_name'                     => '',
        'owner_reg_number'                    => '',
        'owner_country'                       => '',
        'owner_address'                       => '',
        'owner_email'                         => '',
        'owner_website'                       => '',
        'dpo_name'                            => '',
        'dpo_email'                           => '',
        'business_description'                => '',
        'target_markets'                      => '',
        'customer_type'                       => 'both',
        'serves_children'                     => 0,
        'minimum_age'                         => '',
        'data_categories'                     => '',
        'sensitive_data_details'              => '',
        'retention_summary'                   => '',
        'processors'                          => '',
        'processor_presets'                   => [],
        'analytics_providers'                 => '',
        'analytics_presets'                   => [],
        'payment_providers'                   => '',
        'payment_presets'                     => [],
        'email_marketing_provider'            => '',
        'email_marketing_presets'             => [],
        'cookie_consent_tool'                 => '',
        'cookie_consent_preset'               => '',
        'refund_policy_summary'               => '',
        'subscription_terms'                  => '',
        'default_review_status'               => 'draft',
        'reviewer_name'                       => '',
        'publish_to_pages'                    => 0,
        'publish_parent_path'                 => '',
        'publish_template'                    => '',
        'publish_body_field'                  => 'body',
        'publish_status'                      => 'unpublished',
        'custom_prompt_global'                => '',
        'custom_prompt_privacy-policy'        => '',
        'custom_prompt_cookie-policy'         => '',
        'custom_prompt_terms-of-use'          => '',
        'custom_prompt_data-processing-agreement' => '',
        'custom_prompt_ccpa-notice'           => '',
        'custom_prompt_refund-policy'         => '',
        'custom_prompt_disclaimer'            => '',
    ];

    public function __construct() {
        require_once __DIR__ . '/ProcessLegalDocs.config.php';
        require_once __DIR__ . '/LegalDocsGenerator.php';
        foreach(self::$configDefaults as $key => $value) {
            $this->$key = $value;
        }
        parent::__construct();
    }

    public function init() {
        parent::init();
    }

    // =========================================================================
    // Execute — Dashboard
    // =========================================================================

    public function execute(): string {
        $this->headline('Legal Docs');
        $this->browserTitle('Legal Docs');

        $out = $this->renderAdminStyles();
        $out .= $this->renderStatusNotices();

        $generator = $this->getGenerator();
        $docs      = $generator->getGeneratedDocuments();
        $hasDocs   = !empty($docs);
        $adminUrl  = $this->config->urls->admin;

        $out .= $this->renderDashboardSummary($docs);

        $out .= '<div class="uk-flex uk-flex-wrap uk-flex-middle uk-margin-medium-bottom" uk-margin>';
        $out .= '<a href="' . $this->page->url . 'generate/" class="uk-button uk-button-primary uk-margin-small-right"><i class="fa fa-plus"></i> Generate Documents</a>';
        if($hasDocs) {
            $out .= '<a href="' . $this->page->url . 'zip/" class="uk-button uk-button-default uk-margin-small-right"><i class="fa fa-download"></i> Export All as ZIP</a>';
        }
        $out .= '<a href="' . $adminUrl . 'module/edit?name=ProcessLegalDocs" class="uk-button uk-button-default"><i class="fa fa-sliders"></i> Settings</a>';
        $out .= '</div>';

        $out .= $this->renderDocumentsList();

        return $out;
    }

    // =========================================================================
    // Execute — Generate
    // =========================================================================

    public function executeGenerate(): string {
        $this->headline('Generate Legal Documents');
        $this->browserTitle('Generate Legal Documents');

        if($this->config->ajax && $this->input->post('action') === 'generate') {
            return $this->handleGenerateAjax();
        }

        $out  = $this->renderAdminStyles();
        $out .= $this->renderStatusNotices();
        $out .= $this->renderGenerateForm();
        return $out;
    }

    // =========================================================================
    // Execute — Preview
    // =========================================================================

    public function executePreview(): string {
        $jurisdiction = $this->sanitizer->name($this->input->get('j') ?? '');
        $slug         = $this->sanitizer->name($this->input->get('d') ?? '');
        $lang         = $this->sanitizer->name($this->input->get('l') ?? '');

        if(!$jurisdiction || !$slug || !$lang) return '<p>Invalid request.</p>';

        $generator = $this->getGenerator();
        $content   = $generator->getDocument($jurisdiction, $slug, $lang);
        if(!$content) return '<p>Document not found.</p>';

        $display = preg_replace('/^---\n.*?\n---\n/s', '', $content);
        $html    = $this->markdownToHtml($display);

        $this->headline('Preview: ' . ucwords(str_replace('-', ' ', $slug)));

        $downloadUrl = $this->page->url . 'download/?j=' . urlencode($jurisdiction) . '&d=' . urlencode($slug) . '&l=' . urlencode($lang);

        $out  = $this->renderAdminStyles();
        $out .= '<div class="uk-flex uk-flex-wrap uk-flex-middle uk-margin-bottom" uk-margin>';
        $out .= '<a href="' . $this->page->url . '" class="uk-button uk-button-default"><i class="fa fa-arrow-left"></i> Back</a> ';
        $out .= '<a href="' . $downloadUrl . '" class="uk-button uk-button-default uk-margin-small-left"><i class="fa fa-download"></i> Download .md</a> ';
        $out .= '<button id="copy-btn" class="uk-button uk-button-default uk-margin-small-left" onclick="copyDoc()"><i class="fa fa-copy"></i> Copy to Clipboard</button>';
        $out .= '</div>';
        $out .= '<div id="doc-content" class="pld-preview uk-margin-top">';
        $out .= $html;
        $out .= '</div>';
        $out .= '<textarea id="doc-raw" class="pld-copy-buffer">' . htmlspecialchars($content) . '</textarea>';
        $out .= '<script>';
        $out .= 'function copyDoc() {';
        $out .= '  var t = document.getElementById("doc-raw");';
        $out .= '  t.select();';
        $out .= '  document.execCommand("copy");';
        $out .= '  var btn = document.getElementById("copy-btn");';
        $out .= '  btn.innerHTML = "<i class=\"fa fa-check\"></i> Copied!";';
        $out .= '  setTimeout(function(){ btn.innerHTML = "<i class=\"fa fa-copy\"></i> Copy to Clipboard"; }, 2000);';
        $out .= '}';
        $out .= '</script>';

        return $out;
    }

    // =========================================================================
    // Execute — Download
    // =========================================================================

    public function executeDownload(): string {
        $jurisdiction = $this->sanitizer->name($this->input->get('j') ?? '');
        $slug         = $this->sanitizer->name($this->input->get('d') ?? '');
        $lang         = $this->sanitizer->name($this->input->get('l') ?? '');

        if(!$jurisdiction || !$slug || !$lang) return '<p>Invalid request.</p>';

        $generator = $this->getGenerator();
        $path      = $generator->getDocumentPath($jurisdiction, $slug, $lang);

        if(!file_exists($path)) return '<p>File not found.</p>';

        $filename = $slug . '.' . $lang . '.md';
        header('Content-Type: text/markdown; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    // =========================================================================
    // Execute — Delete
    // =========================================================================

    public function executeDelete(): string {
        $jurisdiction = $this->sanitizer->name($this->input->get('j') ?? '');
        $slug         = $this->sanitizer->name($this->input->get('d') ?? '');
        $lang         = $this->sanitizer->name($this->input->get('l') ?? '');

        if(!$jurisdiction || !$slug || !$lang) {
            $this->error('Invalid request.');
            $this->session->redirect($this->page->url);
        }

        $generator = $this->getGenerator();
        if($generator->deleteDocument($jurisdiction, $slug, $lang)) {
            $this->message('Document deleted.');
        } else {
            $this->error('Could not delete document.');
        }

        $this->session->redirect($this->page->url);
        return '';
    }

    // =========================================================================
    // Execute — ZIP Export
    // =========================================================================

    public function executeZip(): string {
        $generator = $this->getGenerator();
        $zipPath   = $generator->exportZip();

        if(!$zipPath) {
            $this->error('Could not create ZIP. Make sure documents have been generated and ZipArchive PHP extension is installed.');
            $this->session->redirect($this->page->url);
            return '';
        }

        $filename = 'legal-docs-' . date('Y-m-d') . '.zip';
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($zipPath));
        readfile($zipPath);
        unlink($zipPath);
        exit;
    }

    // =========================================================================
    // Execute — Validate (AJAX)
    // =========================================================================

    public function executeValidate(): string {
        if($this->config->ajax) {
            header('Content-Type: application/json');
            $jurisdiction = $this->sanitizer->name($this->input->get('j') ?? '');
            $slug         = $this->sanitizer->name($this->input->get('d') ?? '');
            $lang         = $this->sanitizer->name($this->input->get('l') ?? '');
            $generator    = $this->getGenerator();
            $result       = $generator->validateDocument($jurisdiction, $slug, $lang);
            echo json_encode($result);
            exit;
        }
        return '';
    }

    // =========================================================================
    // AJAX Handler — Generate
    // =========================================================================

    protected function handleGenerateAjax(): string {
        header('Content-Type: application/json');

        $jurisdiction = $this->sanitizer->name($this->input->post('jurisdiction') ?? '');
        $slug         = $this->sanitizer->name($this->input->post('document') ?? '');
        $lang         = $this->sanitizer->name($this->input->post('language') ?? '');

        if(!$jurisdiction || !$slug || !$lang) {
            echo json_encode(['success' => false, 'error' => 'Missing parameters']);
            exit;
        }

        $generator = $this->getGenerator();
        $result    = $generator->generate($jurisdiction, $slug, $lang);

        echo json_encode($result);
        exit;
    }

    // =========================================================================
    // Render — Status Notices
    // =========================================================================

    protected function renderAdminStyles(): string {
        return '<style>
            .pld-copy-buffer{position:absolute;left:-100vw;}
            .pld-card.is-selected{border-color:var(--pw-main-color);}
            .pld-jur-title{cursor:pointer;}
            .pld-flag{display:inline-flex;width:1.25em;height:1.25em;vertical-align:-0.2em;}
            .pld-flag img{display:block;width:100%;height:100%;}
            .pld-flag--fallback{align-items:center;justify-content:center;}
            .pld-jur-options{display:none;}
            .pld-doc-option{display:flex;align-items:center;cursor:pointer;}
            .pld-doc-option .uk-label{margin-left:auto;}
            .pld-generate-bar{position:sticky;bottom:var(--uk-margin-small-margin);z-index:20;}
            .pld-progress-row{display:grid;grid-template-columns:28px 1fr auto;column-gap:var(--uk-margin-small-margin);align-items:center;border-bottom:1px solid var(--pw-border-color);}
            .pld-progress-row:last-child{border-bottom:0;}
            .pld-preview{max-width:920px;line-height:1.7;}
            @media (max-width:640px){.pld-generate-bar .uk-flex{align-items:stretch;flex-direction:column;}.pld-generate-bar .uk-button{width:100%;}.pld-progress-row{grid-template-columns:24px 1fr;}.pld-progress-row span:last-child{grid-column:2;justify-self:start;}}
        </style>';
    }

    protected function renderDashboardSummary(array $docs): string {
        $docTypes = ProcessLegalDocsConfig::getDocumentTypes();
        $languages = ProcessLegalDocsConfig::getLanguages();

        $jurisdictions = [];
        $langs = [];
        $bytes = 0;

        foreach($docs as $doc) {
            $jurisdictions[$doc['jurisdiction']] = true;
            $langs[$doc['lang']] = true;
            $bytes += (int)($doc['size'] ?? 0);
        }

        $latest = '';
        if(!empty($docs)) {
            $latestDoc = $docs[0];
            foreach($docs as $doc) {
                if(($doc['generated'] ?? '') > ($latestDoc['generated'] ?? '')) $latestDoc = $doc;
            }
            $latestTitle = $docTypes[$latestDoc['slug']]['label'] ?? $latestDoc['slug'];
            $latestLang = $languages[$latestDoc['lang']] ?? strtoupper($latestDoc['lang']);
            $latest = $this->sanitizer->entities($latestTitle . ' · ' . $latestLang);
        }

        $out  = '<div class="uk-child-width-1-4@m uk-child-width-1-2@s uk-grid-small uk-grid-match uk-margin-bottom" uk-grid>';
        $out .= '<div><div class="uk-card uk-card-default uk-card-body uk-card-small"><div class="uk-text-meta uk-text-uppercase">Documents</div><div class="uk-h2 uk-margin-remove">' . count($docs) . '</div><div class="uk-text-small uk-text-muted">Generated files</div></div></div>';
        $out .= '<div><div class="uk-card uk-card-default uk-card-body uk-card-small"><div class="uk-text-meta uk-text-uppercase">Jurisdictions</div><div class="uk-h2 uk-margin-remove">' . count($jurisdictions) . '</div><div class="uk-text-small uk-text-muted">Covered regions</div></div></div>';
        $out .= '<div><div class="uk-card uk-card-default uk-card-body uk-card-small"><div class="uk-text-meta uk-text-uppercase">Languages</div><div class="uk-h2 uk-margin-remove">' . count($langs) . '</div><div class="uk-text-small uk-text-muted">' . $this->formatBytes($bytes) . ' stored</div></div></div>';
        $out .= '<div><div class="uk-card uk-card-default uk-card-body uk-card-small"><div class="uk-text-meta uk-text-uppercase">Latest</div><div class="uk-h5 uk-margin-remove">' . ($latest ?: 'None yet') . '</div><div class="uk-text-small uk-text-muted">Most recent output</div></div></div>';
        $out .= '</div>';

        return $out;
    }

    protected function renderStatusNotices(): string {
        $out     = '';
        $context = $this->modules->getModule('Context', ['noInit' => true]);

        if(!$context) {
            $out .= '<div class="uk-alert uk-alert-warning" uk-alert>';
            $out .= '<i class="fa fa-exclamation-triangle"></i> <strong>Context module not found.</strong> ';
            $out .= 'Documents will be generated without site analysis. <a href="https://github.com/mxmsmnv/Context" target="_blank">Install Context</a> for better results.';
            $out .= '</div>';
        } elseif(!method_exists($context, 'ai') || !$context->ai()->isEnabled()) {
            $out .= '<div class="uk-alert uk-alert-warning" uk-alert>';
            $out .= '<i class="fa fa-exclamation-triangle"></i> <strong>AI not configured.</strong> ';
            $out .= '<a href="' . $this->config->urls->admin . 'module/edit?name=Context">Configure AI in Context module settings</a>.';
            $out .= '</div>';
        }

        if(empty($this->owner_email)) {
            $out .= '<div class="uk-alert uk-alert-warning" uk-alert>';
            $out .= '<i class="fa fa-exclamation-triangle"></i> <strong>Owner information incomplete.</strong> ';
            $out .= '<a href="' . $this->config->urls->admin . 'module/edit?name=ProcessLegalDocs">Complete your settings</a>.';
            $out .= '</div>';
        }

        return $out;
    }

    // =========================================================================
    // Render — Documents List (Dashboard)
    // =========================================================================

    protected function renderDocumentsList(): string {
        $generator = $this->getGenerator();
        $docs      = $generator->getGeneratedDocuments();
        $docTypes  = ProcessLegalDocsConfig::getDocumentTypes();
        $languages = ProcessLegalDocsConfig::getLanguages();
        $jurs      = ProcessLegalDocsConfig::getJurisdictions();
        $adminUrl  = $this->config->urls->admin;

        if(empty($docs)) {
            return '<div class="uk-placeholder uk-text-center">'
                . '<p class="uk-h4 uk-margin-small"><i class="fa fa-file-text-o uk-margin-small-right"></i>No documents generated yet</p>'
                . '<p class="uk-text-muted uk-margin-small">Start with a jurisdiction and language, then generate the first legal pack.</p>'
                . '<div class="uk-margin-top"><a href="' . $this->page->url . 'generate/" class="uk-button uk-button-primary"><i class="fa fa-plus"></i> Generate Documents</a></div>'
                . '</div>';
        }

        $grouped = [];
        foreach($docs as $doc) {
            $grouped[$doc['jurisdiction']][] = $doc;
        }

        $out = '';
        foreach($grouped as $jurisdiction => $jurDocs) {
            $jurName = $jurs[$jurisdiction]['name'] ?? $jurisdiction;
            $out .= '<div class="uk-flex uk-flex-between uk-flex-middle uk-margin-medium-top uk-margin-small-bottom">';
            $out .= '<h3 class="uk-heading-divider uk-margin-remove uk-width-expand">' . $this->sanitizer->entities($jurName) . '</h3>';
            $out .= '<span class="uk-label uk-margin-small-left"><i class="fa fa-files-o"></i> ' . count($jurDocs) . ' documents</span>';
            $out .= '</div>';
            $out .= '<div class="uk-overflow-auto">';
            $out .= '<table class="uk-table uk-table-divider uk-table-hover uk-table-small uk-table-middle">';
            $out .= '<thead><tr><th>Document</th><th>Language</th><th>Status</th><th>Generated</th><th>Size</th><th class="uk-text-right">Actions</th></tr></thead>';
            $out .= '<tbody>';

            foreach($jurDocs as $doc) {
                $title    = $docTypes[$doc['slug']]['label'] ?? $doc['slug'];
                $langName = $languages[$doc['lang']] ?? $doc['lang'];
                $size     = $this->formatBytes($doc['size']);
                $date     = $doc['generated'];
                $status   = $this->formatReviewStatus($doc['review_status'] ?? 'draft');

                $previewUrl  = $this->page->url . 'preview/?j=' . urlencode($doc['jurisdiction']) . '&d=' . urlencode($doc['slug']) . '&l=' . urlencode($doc['lang']);
                $downloadUrl = $this->page->url . 'download/?j=' . urlencode($doc['jurisdiction']) . '&d=' . urlencode($doc['slug']) . '&l=' . urlencode($doc['lang']);
                $deleteUrl   = $this->page->url . 'delete/?j=' . urlencode($doc['jurisdiction']) . '&d=' . urlencode($doc['slug']) . '&l=' . urlencode($doc['lang']);

                $jEnc = $this->sanitizer->entities($doc['jurisdiction']);
                $dEnc = $this->sanitizer->entities($doc['slug']);
                $lEnc = $this->sanitizer->entities($doc['lang']);

                $out .= '<tr>';
                $out .= '<td><strong><i class="fa fa-file-text-o"></i> ' . $this->sanitizer->entities($title) . '</strong><br><span class="uk-text-muted uk-text-small">' . $this->sanitizer->entities($doc['slug']) . '</span></td>';
                $out .= '<td>' . $this->sanitizer->entities($langName) . '</td>';
                $out .= '<td>' . $status . '</td>';
                $out .= '<td>' . $date . '</td>';
                $out .= '<td>' . $size . '</td>';
                $out .= '<td class="uk-text-right"><div class="uk-flex uk-flex-wrap uk-flex-middle uk-flex-right" uk-margin>';
                $out .= '<a href="' . $previewUrl . '" class="uk-button uk-button-default uk-button-small uk-margin-small-right"><i class="fa fa-eye"></i> Preview</a>';
                $out .= '<a href="' . $downloadUrl . '" class="uk-button uk-button-default uk-button-small uk-margin-small-right"><i class="fa fa-download"></i> Download</a>';
                $out .= '<a href="#" class="uk-button uk-button-default uk-button-small uk-margin-small-right" onclick="validateDoc(\'' . $jEnc . '\',\'' . $dEnc . '\',\'' . $lEnc . '\',this);return false;"><i class="fa fa-check-circle"></i> Validate</a>';
                $out .= '<a href="#" class="uk-button uk-button-default uk-button-small uk-margin-small-right" onclick="regenerate(\'' . $jEnc . '\',\'' . $dEnc . '\',\'' . $lEnc . '\',this);return false;"><i class="fa fa-refresh"></i> Regenerate</a>';
                $out .= '<a href="#" class="uk-button uk-button-danger uk-button-small" onclick="if(confirm(\'Delete this document?\')) location.href=\'' . $deleteUrl . '\';return false;"><i class="fa fa-trash"></i> Delete</a>';
                $out .= '</div>';
                $out .= '</td>';
                $out .= '</tr>';
            }

            $out .= '</tbody></table></div>';
        }

        // Dashboard JS — regenerate and validate functions
        $pageUrl = $this->page->url;
        $out .= '<script>';
        $out .= 'function regenerate(j,d,l,link){';
        $out .= '  if(!confirm("Regenerate this document? The existing file will be overwritten.")) return;';
        $out .= '  link.innerHTML="<i class=\"fa fa-spinner fa-spin\"></i> Generating...";';
        $out .= '  link.style.pointerEvents="none";';
        $out .= '  var fd=new FormData();';
        $out .= '  fd.append("action","generate");fd.append("jurisdiction",j);fd.append("document",d);fd.append("language",l);';
        $out .= '  fetch("' . $adminUrl . 'setup/legal-docs/generate/",{method:"POST",body:fd,headers:{"X-Requested-With":"XMLHttpRequest"}})';
        $out .= '  .then(function(r){return r.json();})';
        $out .= '  .then(function(data){';
        $out .= '    if(data.success){link.innerHTML="<i class=\"fa fa-check\"></i> Done";setTimeout(function(){location.reload();},1000);}';
        $out .= '    else{link.innerHTML="<i class=\"fa fa-times\"></i> Error: "+data.error;link.style.pointerEvents="auto";}';
        $out .= '  });';
        $out .= '}';
        $out .= 'function validateDoc(j,d,l,link){';
        $out .= '  var orig=link.innerHTML;';
        $out .= '  link.innerHTML="<i class=\"fa fa-spinner fa-spin\"></i>";';
        $out .= '  link.style.pointerEvents="none";';
        $out .= '  fetch("' . $pageUrl . 'validate/?j="+encodeURIComponent(j)+"&d="+encodeURIComponent(d)+"&l="+encodeURIComponent(l),{headers:{"X-Requested-With":"XMLHttpRequest"}})';
        $out .= '  .then(function(r){return r.json();})';
        $out .= '  .then(function(data){';
        $out .= '    link.style.pointerEvents="auto";';
        $out .= '    var tone=data.score>=80?"uk-text-success":data.score>=50?"uk-text-warning":"uk-text-danger";';
        $out .= '    var icon=data.score>=80?"check-circle":"exclamation-circle";';
        $out .= '    link.innerHTML="<i class=\"fa fa-"+icon+" "+tone+"\"></i> "+data.score+"%";';
        $out .= '    var msg="Score: "+data.score+"%\nWords: "+data.word_count;';
        $out .= '    if(data.missing.length) msg+="\n\nMissing:\n- "+data.missing.join("\n- ");';
        $out .= '    if(data.warnings.length) msg+="\n\nWarnings:\n- "+data.warnings.join("\n- ");';
        $out .= '    alert(msg);';
        $out .= '  }).catch(function(){link.innerHTML=orig;link.style.pointerEvents="auto";});';
        $out .= '}';
        $out .= '</script>';

        return $out;
    }

    // =========================================================================
    // Render — Generate Form
    // =========================================================================

    protected function renderGenerateForm(): string {
        $jurisdictions = ProcessLegalDocsConfig::getJurisdictions();
        $jurDocs       = ProcessLegalDocsConfig::getJurisdictionDocuments();
        $docTypes      = ProcessLegalDocsConfig::getDocumentTypes();
        $languages     = ProcessLegalDocsConfig::getLanguages();
        $jurLanguages  = ProcessLegalDocsConfig::getJurisdictionLanguages();
        $adminUrl      = $this->config->urls->admin;

        $regions = [];
        foreach($jurisdictions as $code => $info) {
            $regions[$info['region']][$code] = $info;
        }

        $out  = '<div class="uk-alert uk-alert-primary" uk-alert>';
        $out .= '<strong><i class="fa fa-info-circle"></i> Generate legal document packs</strong>';
        $out .= '<div class="uk-text-muted uk-margin-small-top">Select one or more jurisdictions, choose a language per jurisdiction, and pick the documents to generate. Existing files will be overwritten.</div>';
        $out .= '</div>';

        $out .= '<div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-bottom">';
        $out .= '<label class="uk-form-label" for="jurisdiction-search">Search jurisdictions</label>';
        $out .= '<div class="uk-search uk-search-default uk-width-1-1 uk-margin-small-top">';
        $out .= '<span uk-search-icon></span>';
        $out .= '<input id="jurisdiction-search" class="uk-search-input" type="search" placeholder="Search by country, law, region, or code..." autocomplete="off">';
        $out .= '</div>';
        $out .= '<div class="uk-text-small uk-text-muted uk-margin-small-top"><span id="jurisdiction-search-count">' . count($jurisdictions) . '</span> jurisdictions shown</div>';
        $out .= '</div>';
        $out .= '<div id="jurisdiction-no-results" class="uk-placeholder uk-text-center" hidden>No jurisdictions match this search.</div>';

        foreach($regions as $region => $jurList) {
            $out .= '<section class="uk-margin-medium-top jur-region-section" data-region="' . $this->sanitizer->entities($region) . '">';
            $out .= '<div class="uk-flex uk-flex-between uk-flex-middle uk-margin-small-bottom">';
            $out .= '<h3 class="uk-heading-divider uk-margin-remove uk-width-expand">' . $this->sanitizer->entities($region) . '</h3>';
            $out .= '<span class="uk-label uk-margin-small-left"><i class="fa fa-map-marker"></i> <span class="jur-region-count">' . count($jurList) . '</span> jurisdictions</span>';
            $out .= '</div>';
            $out .= '<div class="uk-child-width-1-3@m uk-child-width-1-2@s uk-grid-small uk-grid-match" uk-grid>';

            foreach($jurList as $code => $info) {
                $docs    = $jurDocs[$code] ?? ['required' => [], 'optional' => []];
                $allDocs = array_merge($docs['required'], $docs['optional']);
                $flag    = $this->getJurisdictionFlag($code);
                $search  = strtolower($code . ' ' . $region . ' ' . $info['name']);
                $allowedLanguages = $jurLanguages[$code] ?? ['en'];

                $out .= '<div class="jur-item" data-search="' . $this->sanitizer->entities($search) . '">';
                $out .= '<div class="pld-card uk-card uk-card-default uk-card-body uk-card-small" id="card-' . $code . '">';
                $out .= '<label class="pld-jur-title uk-flex uk-flex-middle uk-text-bold">';
                $out .= '<input type="checkbox" class="uk-checkbox jur-checkbox" data-jur="' . $code . '" onchange="toggleJur(\'' . $code . '\')">';
                $out .= '<span class="uk-margin-small-left"><span class="pld-flag">' . $flag . '</span> ' . $this->sanitizer->entities($info['name']) . '<br><span class="uk-text-muted uk-text-small">' . count($docs['required']) . ' required, ' . count($docs['optional']) . ' optional</span></span>';
                $out .= '</label>';

                $out .= '<div id="jur-options-' . $code . '" class="pld-jur-options uk-margin-top uk-padding-small uk-background-muted">';

                $out .= '<div class="uk-margin-small">';
                $out .= '<label class="uk-form-label">Language</label>';
                $out .= '<select name="lang[' . $code . ']" class="uk-select uk-form-small">';
                foreach($allowedLanguages as $lCode) {
                    if(!isset($languages[$lCode])) continue;
                    $lName = $languages[$lCode];
                    $selected = $lCode === 'en' ? ' selected' : '';
                    $out .= '<option value="' . $lCode . '"' . $selected . '>' . $this->sanitizer->entities($lName) . '</option>';
                }
                $out .= '</select>';
                $out .= '</div>';

                $out .= '<div class="uk-text uk-text-muted uk-margin-small-bottom">Documents</div>';
                foreach($allDocs as $docSlug) {
                    $docLabel   = $docTypes[$docSlug]['label'] ?? $docSlug;
                    $isOptional = in_array($docSlug, $docs['optional']);
                    $checked    = $isOptional ? '' : ' checked';
                    $badgeClass = $isOptional ? 'uk-label' : 'uk-label uk-label-success';
                    $out .= '<label class="pld-doc-option">';
                    $out .= '<input type="checkbox" class="uk-checkbox" name="docs[' . $code . '][]" value="' . $docSlug . '"' . $checked . '>';
                    $out .= '<span class="uk-text uk-margin-small-left">' . $this->sanitizer->entities($docLabel) . '</span>';
                    $out .= ' <span class="' . $badgeClass . '">' . ($isOptional ? 'optional' : 'required') . '</span>';
                    $out .= '</label>';
                }

                $out .= '</div>';
                $out .= '</div>';
                $out .= '</div>';
            }

            $out .= '</div></section>';
        }

        $out .= '<div class="pld-generate-bar uk-card uk-card-default uk-card-body uk-card-small uk-margin-top">';
        $out .= '<div class="uk-flex uk-flex-between uk-flex-middle">';
        $out .= '<div><strong>Ready to generate</strong><br><span class="uk-text-muted uk-text-small" id="selection-summary">Select jurisdictions to build the queue.</span></div>';
        $out .= '<button type="button" id="generate-btn" class="uk-button uk-button-primary" onclick="startGeneration()">';
        $out .= '<i class="fa fa-cog"></i> Generate Selected Documents';
        $out .= '</button>';
        $out .= '</div>';
        $out .= '</div>';

        $out .= '<div id="progress-area" class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-top" hidden></div>';
        $out .= '<div id="view-docs-link" class="uk-margin-top" hidden>';
        $out .= '<a href="' . $adminUrl . 'setup/legal-docs/" class="uk-button uk-button-primary"><i class="fa fa-list"></i> View Generated Documents</a>';
        $out .= '</div>';

        // Generate form JS
        $out .= '<script>';
        $out .= 'function filterJurisdictions(){';
        $out .= '  var input=document.getElementById("jurisdiction-search");';
        $out .= '  var q=(input&&input.value?input.value:"").toLowerCase().trim();';
        $out .= '  var total=0;';
        $out .= '  document.querySelectorAll(".jur-region-section").forEach(function(section){';
        $out .= '    var visibleInRegion=0;';
        $out .= '    section.querySelectorAll(".jur-item").forEach(function(item){';
        $out .= '      var show=!q || item.getAttribute("data-search").indexOf(q)!==-1;';
        $out .= '      item.hidden=!show;';
        $out .= '      if(show){visibleInRegion++;total++;}';
        $out .= '    });';
        $out .= '    section.hidden=visibleInRegion===0;';
        $out .= '    var count=section.querySelector(".jur-region-count");';
        $out .= '    if(count) count.textContent=visibleInRegion;';
        $out .= '  });';
        $out .= '  var totalEl=document.getElementById("jurisdiction-search-count");';
        $out .= '  if(totalEl) totalEl.textContent=total;';
        $out .= '  var empty=document.getElementById("jurisdiction-no-results");';
        $out .= '  if(empty) empty.hidden=total!==0;';
        $out .= '}';
        $out .= 'document.addEventListener("input",function(e){if(e.target&&e.target.id==="jurisdiction-search") filterJurisdictions();});';
        $out .= 'function updateSelectionSummary(){';
        $out .= '  var checks=document.querySelectorAll(".jur-checkbox:checked");';
        $out .= '  var docs=0;';
        $out .= '  checks.forEach(function(cb){var jur=cb.getAttribute("data-jur");docs+=Array.from(document.getElementsByName("docs["+jur+"][]")).filter(function(el){return el.checked;}).length;});';
        $out .= '  var summary=document.getElementById("selection-summary");';
        $out .= '  if(summary) summary.textContent=checks.length?checks.length+" jurisdiction(s), "+docs+" document(s) queued.":"Select jurisdictions to build the queue.";';
        $out .= '}';
        $out .= 'function toggleJur(code){';
        $out .= '  var cb=document.querySelector(".jur-checkbox[data-jur="+code+"]");';
        $out .= '  var opt=document.getElementById("jur-options-"+code);';
        $out .= '  var card=document.getElementById("card-"+code);';
        $out .= '  opt.style.display=cb.checked?"block":"none";';
        $out .= '  if(cb.checked){card.classList.add("is-selected");}';
        $out .= '  else{card.classList.remove("is-selected");}';
        $out .= '  updateSelectionSummary();';
        $out .= '}';
        $out .= 'document.addEventListener("change",function(e){if(e.target && e.target.name && e.target.name.indexOf("docs[")===0) updateSelectionSummary();});';
        $out .= 'async function startGeneration(){';
        $out .= '  var checks=document.querySelectorAll(".jur-checkbox:checked");';
        $out .= '  if(checks.length===0){alert("Select at least one jurisdiction.");return;}';
        $out .= '  var btn=document.getElementById("generate-btn");';
        $out .= '  btn.disabled=true;';
        $out .= '  btn.innerHTML="<i class=\"fa fa-spinner fa-spin\"></i> Queuing...";';
        $out .= '  var progress=document.getElementById("progress-area");';
        $out .= '  progress.hidden=false;';
        $out .= '  progress.innerHTML="<h3 class=\"uk-margin-remove-top\">Generation Progress</h3><div id=\"progress-list\"></div>";';
        $out .= '  document.getElementById("view-docs-link").hidden=true;';
        $out .= '  var list=document.getElementById("progress-list");';
        $out .= '  var tasks=[];';
        $out .= '  checks.forEach(function(cb){';
        $out .= '    var jur=cb.getAttribute("data-jur");';
        $out .= '    var langEl=document.getElementsByName("lang["+jur+"]")[0];var lang=langEl?langEl.value:"en";';
        $out .= '    var allDocs=document.getElementsByName("docs["+jur+"][]");var docInputs=Array.from(allDocs).filter(function(el){return el.checked;});';
        $out .= '    docInputs.forEach(function(d){tasks.push({jur:jur,doc:d.value,lang:lang});});';
        $out .= '  });';
        $out .= '  if(tasks.length===0){alert("Select at least one document.");progress.hidden=true;btn.disabled=false;btn.innerHTML="<i class=\"fa fa-cog\"></i> Generate Selected Documents";return;}';
        $out .= '  tasks.forEach(function(t,i){';
        $out .= '    var rowId="row-"+i;';
        $out .= '    list.innerHTML+="<div id=\""+rowId+"\" class=\"pld-progress-row uk-padding-small\">"';
        $out .= '      +"<span id=\"icon-"+rowId+"\"><i class=\"fa fa-clock-o uk-text-muted\"></i></span>"';
        $out .= '      +"<strong>"+t.jur+" / "+t.doc+" <span class=\"uk-text-muted\">("+t.lang+")</span></strong>"';
        $out .= '      +"<span id=\"status-"+rowId+"\" class=\"uk-text-muted uk-text-small\">queued</span>"';
        $out .= '      +"</div>";';
        $out .= '  });';
        $out .= '  btn.innerHTML="<i class=\"fa fa-cog fa-spin\"></i> Generating (0/"+tasks.length+")...";';
        $out .= '  var completed=0,errors=0;';
        $out .= '  for(var i=0;i<tasks.length;i++){';
        $out .= '    var t=tasks[i];var rowId="row-"+i;';
        $out .= '    document.getElementById("icon-"+rowId).innerHTML="<i class=\"fa fa-spinner fa-spin uk-text-muted\"></i>";';
        $out .= '    document.getElementById("status-"+rowId).innerHTML="<span class=\"uk-text-muted\">generating...</span>";';
        $out .= '    document.getElementById(rowId).scrollIntoView({behavior:"smooth",block:"nearest"});';
        $out .= '    try{';
        $out .= '      var fd=new FormData();';
        $out .= '      fd.append("action","generate");fd.append("jurisdiction",t.jur);fd.append("document",t.doc);fd.append("language",t.lang);';
        $out .= '      var r=await fetch("' . $adminUrl . 'setup/legal-docs/generate/",{method:"POST",body:fd,headers:{"X-Requested-With":"XMLHttpRequest"}});';
        $out .= '      var data=await r.json();';
        $out .= '      completed++;';
        $out .= '      btn.innerHTML="<i class=\"fa fa-cog fa-spin\"></i> Generating ("+completed+"/"+tasks.length+")...";';
        $out .= '      if(data.success){';
        $out .= '        document.getElementById("icon-"+rowId).innerHTML="<i class=\"fa fa-check-circle uk-text-success\"></i>";';
        $out .= '        document.getElementById("status-"+rowId).innerHTML="<span class=\"uk-text-success\">done</span>";';
        $out .= '      }else{';
        $out .= '        errors++;';
        $out .= '        document.getElementById("icon-"+rowId).innerHTML="<i class=\"fa fa-times-circle uk-text-danger\"></i>";';
        $out .= '        document.getElementById("status-"+rowId).innerHTML="<span class=\"uk-text-danger\">"+(data.error||"error")+"</span>";';
        $out .= '      }';
        $out .= '    }catch(e){';
        $out .= '      errors++;completed++;';
        $out .= '      document.getElementById("icon-"+rowId).innerHTML="<i class=\"fa fa-times-circle uk-text-danger\"></i>";';
        $out .= '      document.getElementById("status-"+rowId).innerHTML="<span class=\"uk-text-danger\">request failed</span>";';
        $out .= '    }';
        $out .= '  }';
        $out .= '  var summary=completed+"/"+tasks.length+" documents processed";';
        $out .= '  if(errors>0) summary+=" ("+errors+" errors)";';
        $out .= '  btn.disabled=false;';
        $out .= '  btn.innerHTML="<i class=\"fa fa-check\"></i> "+summary;';
        $out .= '  document.getElementById("view-docs-link").hidden=false;';
        $out .= '}';
        $out .= '</script>';

        return $out;
    }

    // =========================================================================
    // Module Settings
    // =========================================================================

    public static function getModuleConfigInputfields(array $data): InputfieldWrapper {
        require_once __DIR__ . '/ProcessLegalDocs.config.php';
        require_once __DIR__ . '/LegalDocsGenerator.php';

        $modules     = wire('modules');
        $inputfields = new InputfieldWrapper();
        $data        = array_merge(self::$configDefaults, $data);

        // Disclaimer notice
        $f = $modules->get('InputfieldMarkup');
        $f->value = '<div class="uk-alert uk-alert-warning">'
            . '<i class="fa fa-exclamation-triangle"></i> <strong>Legal Disclaimer:</strong> '
            . 'Documents generated by this module are AI-generated templates only. '
            . 'They do not constitute legal advice. Always consult a qualified lawyer before publishing.'
            . '</div>';
        $inputfields->add($f);

        // ── Owner Information ────────────────────────────────────────────────
        $fieldset = $modules->get('InputfieldFieldset');
        $fieldset->label = 'Owner Information';
        $fieldset->icon  = 'user';
        $fieldset->collapsed = Inputfield::collapsedNo;

        $f = $modules->get('InputfieldSelect');
        $f->name  = 'owner_type';
        $f->label = 'Owner Type';
        $f->addOption('company',    'Company / Organization');
        $f->addOption('individual', 'Individual / Sole Trader');
        $f->value = $data['owner_type'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name   = 'owner_company_name';
        $f->label  = 'Company Name';
        $f->value  = $data['owner_company_name'];
        $f->showIf = 'owner_type=company';
        $f->columnWidth = 34;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name   = 'owner_reg_number';
        $f->label  = 'Registration Number';
        $f->notes  = 'Company registration / VAT number (optional)';
        $f->value  = $data['owner_reg_number'];
        $f->showIf = 'owner_type=company';
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name   = 'owner_first_name';
        $f->label  = 'First Name';
        $f->value  = $data['owner_first_name'];
        $f->showIf = 'owner_type=individual';
        $f->columnWidth = 50;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name   = 'owner_last_name';
        $f->label  = 'Last Name';
        $f->value  = $data['owner_last_name'];
        $f->showIf = 'owner_type=individual';
        $f->columnWidth = 50;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'owner_country';
        $f->label = 'Country of Registration';
        $f->value = $data['owner_country'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldEmail');
        $f->name  = 'owner_email';
        $f->label = 'Legal Contact Email';
        $f->value = $data['owner_email'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldURL');
        $f->name  = 'owner_website';
        $f->label = 'Website URL';
        $f->notes = 'Leave blank to use ProcessWire site URL';
        $f->value = $data['owner_website'] ?: wire('config')->urls->httpRoot;
        $f->columnWidth = 34;
        $fieldset->add($f);

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'owner_address';
        $f->label = 'Legal Address';
        $f->value = $data['owner_address'];
        $f->rows  = 3;
        $f->columnWidth = 100;
        $fieldset->add($f);

        $inputfields->add($fieldset);

        // ── Review & Publishing ──────────────────────────────────────────────
        $fieldset = $modules->get('InputfieldFieldset');
        $fieldset->label = 'Review & Page Publishing';
        $fieldset->icon  = 'check-square-o';
        $fieldset->notes = 'Generated files are always saved as Markdown. Page publishing is optional and only runs when enabled and configured.';
        $fieldset->collapsed = Inputfield::collapsedYes;

        $f = $modules->get('InputfieldSelect');
        $f->name  = 'default_review_status';
        $f->label = 'Default Review Status';
        $f->addOption('draft', 'Draft');
        $f->addOption('owner_reviewed', 'Reviewed by owner');
        $f->addOption('lawyer_reviewed', 'Reviewed by lawyer');
        $f->addOption('published', 'Published');
        $f->value = $data['default_review_status'];
        $f->columnWidth = 50;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'reviewer_name';
        $f->label = 'Reviewer Name';
        $f->notes = 'Optional. Stored in generated document metadata.';
        $f->value = $data['reviewer_name'];
        $f->columnWidth = 50;
        $fieldset->add($f);

        $f = $modules->get('InputfieldCheckbox');
        $f->name  = 'publish_to_pages';
        $f->label = 'Create/update ProcessWire pages after generation';
        $f->notes = 'Requires parent path, template, and body field below.';
        $f->checked = !empty($data['publish_to_pages']);
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'publish_parent_path';
        $f->label = 'Parent Page Path';
        $f->notes = 'Example: /legal/';
        $f->value = $data['publish_parent_path'];
        $f->showIf = 'publish_to_pages=1';
        $f->columnWidth = 25;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'publish_template';
        $f->label = 'Page Template';
        $f->notes = 'Template name for generated legal pages.';
        $f->value = $data['publish_template'];
        $f->showIf = 'publish_to_pages=1';
        $f->columnWidth = 25;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'publish_body_field';
        $f->label = 'Body Field';
        $f->notes = 'Field that receives generated Markdown content.';
        $f->value = $data['publish_body_field'];
        $f->showIf = 'publish_to_pages=1';
        $f->columnWidth = 25;
        $fieldset->add($f);

        $f = $modules->get('InputfieldSelect');
        $f->name  = 'publish_status';
        $f->label = 'Page Status';
        $f->addOption('unpublished', 'Create/update as unpublished');
        $f->addOption('published', 'Publish immediately');
        $f->value = $data['publish_status'];
        $f->showIf = 'publish_to_pages=1';
        $f->columnWidth = 25;
        $fieldset->add($f);

        $inputfields->add($fieldset);

        // ── Business & Audience ──────────────────────────────────────────────
        $fieldset = $modules->get('InputfieldFieldset');
        $fieldset->label = 'Business & Audience';
        $fieldset->icon  = 'briefcase';
        $fieldset->notes = 'These details help AI avoid guessing how your website operates and which users it targets.';
        $fieldset->collapsed = Inputfield::collapsedNo;

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'business_description';
        $f->label = 'Business Description';
        $f->notes = 'Briefly describe what the website or business does.';
        $f->value = $data['business_description'];
        $f->rows  = 3;
        $f->columnWidth = 100;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'target_markets';
        $f->label = 'Target Markets / Countries';
        $f->notes = 'Examples: EU, UK, California, UAE, worldwide.';
        $f->value = $data['target_markets'];
        $f->columnWidth = 50;
        $fieldset->add($f);

        $f = $modules->get('InputfieldSelect');
        $f->name  = 'customer_type';
        $f->label = 'Customer Type';
        $f->addOption('b2c', 'B2C / Consumers');
        $f->addOption('b2b', 'B2B / Businesses');
        $f->addOption('both', 'Both B2C and B2B');
        $f->value = $data['customer_type'];
        $f->columnWidth = 50;
        $fieldset->add($f);

        $f = $modules->get('InputfieldCheckbox');
        $f->name  = 'serves_children';
        $f->label = 'Serves children or minors';
        $f->notes = 'Enable if the website is directed to children/minors or knowingly collects their data.';
        $f->checked = !empty($data['serves_children']);
        $f->columnWidth = 50;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name   = 'minimum_age';
        $f->label  = 'Minimum Age';
        $f->notes  = 'Examples: 13, 16, 18.';
        $f->value  = $data['minimum_age'];
        $f->showIf = 'serves_children=1';
        $f->columnWidth = 50;
        $fieldset->add($f);

        $inputfields->add($fieldset);

        // ── Data & Processing ────────────────────────────────────────────────
        $fieldset = $modules->get('InputfieldFieldset');
        $fieldset->label = 'Data & Processing';
        $fieldset->icon  = 'database';
        $fieldset->collapsed = Inputfield::collapsedYes;

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'data_categories';
        $f->label = 'Data Categories Collected';
        $f->notes = 'Examples: contact data, account data, billing data, analytics data, uploaded files, support messages, marketing preferences.';
        $f->value = $data['data_categories'];
        $f->rows  = 3;
        $fieldset->add($f);

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'sensitive_data_details';
        $f->label = 'Sensitive Data Details';
        $f->notes = 'Leave blank if none. Mention health, biometric, precise location, children data, government ID, etc. only if applicable.';
        $f->value = $data['sensitive_data_details'];
        $f->rows  = 3;
        $fieldset->add($f);

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'retention_summary';
        $f->label = 'Data Retention Summary';
        $f->notes = 'Examples: account data until deletion, invoices for 7 years, analytics for 14 months.';
        $f->value = $data['retention_summary'];
        $f->rows  = 3;
        $fieldset->add($f);

        $inputfields->add($fieldset);

        // ── Third Parties ────────────────────────────────────────────────────
        $fieldset = $modules->get('InputfieldFieldset');
        $fieldset->label = 'Third Parties & Processors';
        $fieldset->icon  = 'exchange';
        $fieldset->collapsed = Inputfield::collapsedYes;

        $f = $modules->get('InputfieldAsmSelect');
        $f->name  = 'processor_presets';
        $f->label = 'Processor Presets';
        foreach(self::getServicePresetOptions('processors') as $value => $label) $f->addOption($value, $label);
        $f->value = $data['processor_presets'];
        $f->columnWidth = 100;
        $fieldset->add($f);

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'processors';
        $f->label = 'Processors / Sub-processors';
        $f->notes = 'Additional hosting, CDN, CRM, support, email, storage, AI, or other vendors.';
        $f->value = $data['processors'];
        $f->rows  = 3;
        $fieldset->add($f);

        $f = $modules->get('InputfieldAsmSelect');
        $f->name  = 'analytics_presets';
        $f->label = 'Analytics Presets';
        foreach(self::getServicePresetOptions('analytics') as $value => $label) $f->addOption($value, $label);
        $f->value = $data['analytics_presets'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'analytics_providers';
        $f->label = 'Other Analytics Providers';
        $f->notes = 'Examples: custom analytics, server logs.';
        $f->value = $data['analytics_providers'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldAsmSelect');
        $f->name  = 'payment_presets';
        $f->label = 'Payment Presets';
        foreach(self::getServicePresetOptions('payments') as $value => $label) $f->addOption($value, $label);
        $f->value = $data['payment_presets'];
        $f->columnWidth = 34;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'payment_providers';
        $f->label = 'Other Payment Providers';
        $f->notes = 'Examples: bank transfer, local payment processor.';
        $f->value = $data['payment_providers'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldAsmSelect');
        $f->name  = 'email_marketing_presets';
        $f->label = 'Email / Marketing Presets';
        foreach(self::getServicePresetOptions('email') as $value => $label) $f->addOption($value, $label);
        $f->value = $data['email_marketing_presets'];
        $f->columnWidth = 34;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'email_marketing_provider';
        $f->label = 'Other Email / Marketing Provider';
        $f->notes = 'Examples: custom SMTP, local newsletter provider, none.';
        $f->value = $data['email_marketing_provider'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $inputfields->add($fieldset);

        // ── Commerce & Policies ──────────────────────────────────────────────
        $fieldset = $modules->get('InputfieldFieldset');
        $fieldset->label = 'Commerce & Policies';
        $fieldset->icon  = 'shopping-cart';
        $fieldset->collapsed = Inputfield::collapsedYes;

        $f = $modules->get('InputfieldSelect');
        $f->name  = 'cookie_consent_preset';
        $f->label = 'Cookie Consent Preset';
        $f->addOption('', 'Not specified');
        foreach(self::getServicePresetOptions('cookies') as $value => $label) $f->addOption($value, $label);
        $f->value = $data['cookie_consent_preset'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldText');
        $f->name  = 'cookie_consent_tool';
        $f->label = 'Other Cookie Consent Tool';
        $f->notes = 'Examples: custom banner, CMP not listed above, none.';
        $f->value = $data['cookie_consent_tool'];
        $f->columnWidth = 33;
        $fieldset->add($f);

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'refund_policy_summary';
        $f->label = 'Refund Policy Summary';
        $f->notes = 'Examples: 14-day refund, digital products non-refundable after download, custom approval.';
        $f->value = $data['refund_policy_summary'];
        $f->rows  = 3;
        $f->columnWidth = 34;
        $fieldset->add($f);

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'subscription_terms';
        $f->label = 'Subscription / Renewal / Cancellation Terms';
        $f->notes = 'Leave blank if not applicable.';
        $f->value = $data['subscription_terms'];
        $f->rows  = 3;
        $f->columnWidth = 33;
        $fieldset->add($f);

        $inputfields->add($fieldset);

        // ── DPO ─────────────────────────────────────────────────────────────
        $fieldset = $modules->get('InputfieldFieldset');
        $fieldset->label = 'Data Protection Officer (DPO)';
        $fieldset->icon  = 'shield';
        $fieldset->notes = 'Required under EU GDPR for certain organizations. Leave blank if not applicable.';
        $fieldset->collapsed = Inputfield::collapsedYes;

        $f = $modules->get('InputfieldText');
        $f->name  = 'dpo_name';
        $f->label = 'DPO Name';
        $f->value = $data['dpo_name'];
        $f->columnWidth = 50;
        $fieldset->add($f);

        $f = $modules->get('InputfieldEmail');
        $f->name  = 'dpo_email';
        $f->label = 'DPO Email';
        $f->value = $data['dpo_email'];
        $f->columnWidth = 50;
        $fieldset->add($f);

        $inputfields->add($fieldset);

        // ── Custom Prompts ───────────────────────────────────────────────────
        $fieldset = $modules->get('InputfieldFieldset');
        $fieldset->label = 'Custom Prompt Instructions';
        $fieldset->icon  = 'pencil';
        $fieldset->notes = 'Additional instructions appended to the AI prompt. Use to add specific requirements, tone preferences, or legal clauses relevant to your business.';
        $fieldset->collapsed = Inputfield::collapsedYes;

        $f = $modules->get('InputfieldTextarea');
        $f->name  = 'custom_prompt_global';
        $f->label = 'Global Instructions (all documents)';
        $f->notes = 'Applied to every document. E.g. "Always mention our ISO 27001 certification."';
        $f->value = $data['custom_prompt_global'];
        $f->rows  = 3;
        $fieldset->add($f);

        $docTypes = ProcessLegalDocsConfig::getDocumentTypes();
        foreach($docTypes as $slug => $docInfo) {
            $f = $modules->get('InputfieldTextarea');
            $f->name      = 'custom_prompt_' . $slug;
            $f->label     = $docInfo['label'] . ' — custom instructions';
            $f->value     = $data['custom_prompt_' . $slug] ?? '';
            $f->rows      = 2;
            $f->collapsed = Inputfield::collapsedYes;
            $fieldset->add($f);
        }

        $inputfields->add($fieldset);

        // ── AI Status ────────────────────────────────────────────────────────
        $context = wire('modules')->getModule('Context', ['noInit' => true]);
        if(!$context) {
            $aiStatus = '<div class="uk-alert uk-alert-warning">'
                . '<i class="fa fa-exclamation-triangle"></i> Context module not installed. '
                . 'AI generation requires the <a href="https://github.com/mxmsmnv/Context" target="_blank">Context module</a>.'
                . '</div>';
        } elseif(method_exists($context, 'ai') && $context->ai()->isEnabled()) {
            $aiStatus = '<div class="uk-alert uk-alert-success">'
                . '<i class="fa fa-check uk-text-success"></i> AI Gateway connected via Context module. '
                . '<a href="' . wire('config')->urls->admin . 'module/edit?name=Context">Manage AI settings</a>.'
                . '</div>';
        } else {
            $aiStatus = '<div class="uk-alert uk-alert-warning">'
                . '<i class="fa fa-exclamation-triangle"></i> Context module installed but AI not configured. '
                . '<a href="' . wire('config')->urls->admin . 'module/edit?name=Context">Configure AI in Context settings</a>.'
                . '</div>';
        }

        $f = $modules->get('InputfieldMarkup');
        $f->label = 'AI Status';
        $f->value = $aiStatus;
        $inputfields->add($f);

        return $inputfields;
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    protected function getGenerator(): LegalDocsGenerator {
        $cfg = [];
        foreach(array_keys(self::$configDefaults) as $key) {
            $cfg[$key] = $this->$key;
        }
        $basePath = $this->config->paths->assets . 'legal';
        return new LegalDocsGenerator($cfg, $basePath);
    }

    protected function markdownToHtml(string $md): string {
        $html = htmlspecialchars($md, ENT_QUOTES, 'UTF-8');

        // Blockquotes — group consecutive > lines into one uk-alert
        $html = preg_replace_callback('/(&gt; .+\n?)+/', function($m) {
            $lines = array_filter(array_map('trim', explode("\n", trim($m[0]))));
            $text  = implode('<br>', array_map(function($l) {
                return preg_replace('/^&gt;\s*/', '', $l);
            }, $lines));
            return '<div class="uk-alert uk-alert-warning" uk-alert>' . $text . '</div>';
        }, $html);

        // Headings
        $html = preg_replace('/^#### (.+)$/m', '<h4 class="uk-margin-top">$1</h4>', $html);
        $html = preg_replace('/^### (.+)$/m',  '<h3 class="uk-margin-top">$1</h3>', $html);
        $html = preg_replace('/^## (.+)$/m',   '<h2 class="uk-heading-divider uk-margin-medium-top">$1</h2>', $html);
        $html = preg_replace('/^# (.+)$/m',    '<h1 class="uk-article-title uk-margin-remove-top">$1</h1>', $html);

        // Inline: bold, italic, code
        $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
        $html = preg_replace('/\*(.+?)\*/',       '<em>$1</em>', $html);
        $html = preg_replace('/`(.+?)`/',           '<code>$1</code>', $html);

        // Links [text](url)
        $html = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $html);

        // Tables
        $html = preg_replace_callback('/^(\|.+\|\n?)+/m', function($m) {
            $rows   = array_filter(array_map('trim', explode("\n", trim($m[0]))));
            $out    = '<table class="uk-table uk-table-divider uk-table-small uk-table-middle">';
            $header = true;
            foreach($rows as $row) {
                if(preg_match('/^\|[-| ]+\|$/', $row)) { $header = false; continue; }
                $cells = array_slice(explode('|', $row), 1, -1);
                $tag   = $header ? 'th' : 'td';
                $out  .= '<tr>';
                foreach($cells as $cell) {
                    $out .= '<' . $tag . '>' . trim($cell) . '</' . $tag . '>';
                }
                $out    .= '</tr>';
                $header  = false;
            }
            return $out . '</table>';
        }, $html);

        // Numbered lists
        $html = preg_replace_callback('/^(\d+\. .+\n?)+/m', function($m) {
            $items = array_filter(array_map('trim', explode("\n", trim($m[0]))));
            $out   = '<ol class="uk-list uk-list-decimal">';
            foreach($items as $item) {
                $out .= '<li>' . preg_replace('/^\d+\.\s+/', '', $item) . '</li>';
            }
            return $out . '</ol>';
        }, $html);

        // Unordered lists
        $html = preg_replace_callback('/^(- .+\n?)+/m', function($m) {
            $items = array_filter(array_map('trim', explode("\n", trim($m[0]))));
            $out   = '<ul class="uk-list uk-list-disc">';
            foreach($items as $item) {
                $out .= '<li>' . preg_replace('/^-\s+/', '', $item) . '</li>';
            }
            return $out . '</ul>';
        }, $html);

        // Horizontal rule
        $html = preg_replace('/^---$/m', '<hr class="uk-hr">', $html);

        // Paragraphs
        $html = '<p>' . preg_replace('/\n{2,}/', '</p><p>', $html) . '</p>';
        $clean = ['<p></p>', '<p><h', '<p><blockquote', '<p><ul', '<p><ol', '<p><hr', '<p><table'];
        $fixed = ['',        '<h',   '<blockquote',    '<ul',   '<ol',   '<hr',   '<table'];
        $html = str_replace($clean, $fixed, $html);
        $close = ['</h1></p>', '</h2></p>', '</h3></p>', '</h4></p>', '</blockquote></p>', '</ul></p>', '</ol></p>', '</table></p>'];
        $repl  = ['</h1>',    '</h2>',    '</h3>',    '</h4>',    '</blockquote>',    '</ul>',    '</ol>',    '</table>'];
        $html = str_replace($close, $repl, $html);

        return $html;
    }
    protected function formatBytes(int $bytes): string {
        if($bytes < 1024) return $bytes . ' B';
        if($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }

    protected function formatReviewStatus(string $status): string {
        $labels = [
            'draft' => ['Draft', 'uk-label'],
            'owner_reviewed' => ['Owner reviewed', 'uk-label uk-label-warning'],
            'lawyer_reviewed' => ['Lawyer reviewed', 'uk-label uk-label-success'],
            'published' => ['Published', 'uk-label uk-label-success'],
        ];

        $item = $labels[$status] ?? $labels['draft'];
        return '<span class="' . $item[1] . '">' . $this->sanitizer->entities($item[0]) . '</span>';
    }

    protected static function getServicePresetOptions(string $type): array {
        $options = [
            'processors' => [
                'cloudflare' => 'Cloudflare',
                'aws' => 'Amazon Web Services',
                'google_cloud' => 'Google Cloud',
                'microsoft_azure' => 'Microsoft Azure',
                'digitalocean' => 'DigitalOcean',
                'hetzner' => 'Hetzner',
                'github' => 'GitHub',
                'hubspot' => 'HubSpot',
                'zendesk' => 'Zendesk',
                'intercom' => 'Intercom',
                'openai' => 'OpenAI',
            ],
            'analytics' => [
                'google_analytics' => 'Google Analytics',
                'google_tag_manager' => 'Google Tag Manager',
                'matomo' => 'Matomo',
                'plausible' => 'Plausible',
                'fathom' => 'Fathom Analytics',
                'meta_pixel' => 'Meta Pixel',
                'hotjar' => 'Hotjar',
            ],
            'payments' => [
                'stripe' => 'Stripe',
                'paypal' => 'PayPal',
                'square' => 'Square',
                'adyen' => 'Adyen',
                'razorpay' => 'Razorpay',
                'mollie' => 'Mollie',
                'wise' => 'Wise',
            ],
            'email' => [
                'mailchimp' => 'Mailchimp',
                'brevo' => 'Brevo',
                'klaviyo' => 'Klaviyo',
                'sendgrid' => 'SendGrid',
                'mailgun' => 'Mailgun',
                'postmark' => 'Postmark',
                'hubspot_marketing' => 'HubSpot Marketing',
            ],
            'cookies' => [
                'cookiebot' => 'Cookiebot',
                'onetrust' => 'OneTrust',
                'klaro' => 'Klaro',
                'termly' => 'Termly',
                'iubenda' => 'Iubenda',
                'custom_banner' => 'Custom cookie banner',
                'none' => 'No cookie consent tool',
            ],
        ];

        return $options[$type] ?? [];
    }

    protected function getJurisdictionFlag(string $code): string {
        $flags = [
            'eu_gdpr' => 'eu',
            'eea_gdpr' => 'eu',
            'uk_gdpr' => 'gb',
            'ch_fadp' => 'ch',
            'de_gdpr' => 'de',
            'fr_gdpr' => 'fr',
            'es_gdpr' => 'es',
            'it_gdpr' => 'it',
            'nl_gdpr' => 'nl',
            'ie_gdpr' => 'ie',
            'at_gdpr' => 'at',
            'be_gdpr' => 'be',
            'dk_gdpr' => 'dk',
            'se_gdpr' => 'se',
            'fi_gdpr' => 'fi',
            'no_gdpr' => 'no',
            'is_gdpr' => 'is',
            'li_gdpr' => 'li',
            'pl_gdpr' => 'pl',
            'cz_gdpr' => 'cz',
            'pt_gdpr' => 'pt',
            'gr_gdpr' => 'gr',
            'ro_gdpr' => 'ro',
            'hu_gdpr' => 'hu',
            'hr_gdpr' => 'hr',
            'bg_gdpr' => 'bg',
            'ee_gdpr' => 'ee',
            'lv_gdpr' => 'lv',
            'lt_gdpr' => 'lt',
            'lu_gdpr' => 'lu',
            'mt_gdpr' => 'mt',
            'cy_gdpr' => 'cy',
            'sk_gdpr' => 'sk',
            'si_gdpr' => 'si',
            'ua_pdpl' => 'ua',
            'rs_pdpl' => 'rs',
            'tr_kvkk' => 'tr',
            'ru_152fz' => 'ru',
            'us_ccpa' => 'us',
            'us_coppa' => 'us',
            'us_va_cdpa' => 'us',
            'us_co_cpa' => 'us',
            'us_ct_ctdpa' => 'us',
            'us_ut_ucpa' => 'us',
            'us_or_ocpa' => 'us',
            'us_tx_tdpsa' => 'us',
            'us_mt_mcdpa' => 'us',
            'us_de_dpdpa' => 'us',
            'us_ia_icdpa' => 'us',
            'us_ne_dpa' => 'us',
            'us_nh_dpa' => 'us',
            'us_nj_dpa' => 'us',
            'us_tn_tipa' => 'us',
            'us_mn_mcdpa' => 'us',
            'us_md_odpa' => 'us',
            'us_in_cdpa' => 'us',
            'us_ky_cdpa' => 'us',
            'us_ri_dpa' => 'us',
            'ca_pipeda' => 'ca',
            'au_privacy' => 'au',
            'br_lgpd' => 'br',
            'mx_lfpdppp' => 'mx',
            'ar_pdpa' => 'ar',
            'cl_law19628' => 'cl',
            'co_habeas' => 'co',
            'pe_pdpl' => 'pe',
            'uy_pdpl' => 'uy',
            'jp_appi' => 'jp',
            'kr_pipa' => 'kr',
            'cn_pipl' => 'cn',
            'in_dpdp' => 'in',
            'sg_pdpa' => 'sg',
            'th_pdpa' => 'th',
            'id_pdp' => 'id',
            'my_pdpa' => 'my',
            'ph_dpa' => 'ph',
            'vn_pdpd' => 'vn',
            'tw_pdpa' => 'tw',
            'hk_pdpo' => 'hk',
            'nz_privacy' => 'nz',
            'ae_pdpl' => 'ae',
            'sa_pdpl' => 'sa',
            'qa_pdppl' => 'qa',
            'bh_pdpl' => 'bh',
            'eg_dpl' => 'eg',
            'ma_law0908' => 'ma',
            'il_pppl' => 'il',
            'za_popia' => 'za',
            'ke_dpa' => 'ke',
            'ng_ndpa' => 'ng',
            'rw_dpp' => 'rw',
            'gh_dpa' => 'gh',
        ];

        if(empty($flags[$code])) {
            return '<span class="pld-flag--fallback"><i class="fa fa-globe"></i></span>';
        }

        $country = $flags[$code];
        $src = 'https://cdn.jsdelivr.net/npm/circle-flags@2.8.3/flags/' . $country . '.svg';

        return '<img src="' . $src . '" alt="' . strtoupper($country) . '" loading="lazy" referrerpolicy="no-referrer">';
    }

    public function ___install() {
        parent::___install();
        $path = $this->config->paths->assets . 'legal';
        if(!is_dir($path)) wireMkdir($path);
    }

    public function ___uninstall() {
        parent::___uninstall();
    }
}
