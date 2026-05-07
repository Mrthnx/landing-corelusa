<?php

declare(strict_types=1);

const NAV_ITEMS = [
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'About CORELUSA', 'href' => '/about-us'],
    ['label' => 'Request a Quote', 'href' => '/request-quote'],
    ['label' => 'Contact Us', 'href' => '/contact'],
];

const SERVICE_ITEMS = [
    ['label' => 'VIBRATION ANALYSIS', 'value' => 'vibration-analysis', 'href' => '/our-services/vibration-analysis'],
    ['label' => 'OIL ANALYSIS', 'value' => 'oil-analysis', 'href' => '/our-services/oil-analysis'],
    ['label' => 'INFRARED THERMOGRAPHY', 'value' => 'infrared-thermography', 'href' => '/our-services/infrared-thermography'],
    ['label' => 'LASER ALIGNMENT', 'value' => 'laser-alignment', 'href' => '/our-services/laser-alignment'],
    ['label' => 'DYNAMIC BALANCING', 'value' => 'dynamic-balancing', 'href' => '/our-services/dynamic-balancing'],
    ['label' => 'NOISE EVALUATION', 'value' => 'noise-evaluation', 'href' => '/our-services/noise-evaluation'],
];

// Product pages (ported from landing-monitor v100/v200 content)
const PRODUCT_ITEMS = [
    ['label' => 'V100', 'value' => 'v100', 'href' => '/products/v100'],
    ['label' => 'V200', 'value' => 'v200', 'href' => '/products/v200'],
];

const PRODUCT_CONTENT = [
    'v100' => [
        'badge' => 'PRODUCT',
        'title' => 'PDM Monitor — V100',
        'subtitle' => 'Continuous online monitoring for critical assets with real-time analytics.',
        'image' => '/images/v100.png',
        'stats' => [
            ['value' => '1,000+', 'label' => 'Assets Monitored'],
            ['value' => '5K+', 'label' => 'Industrial Sensors Installed'],
            ['value' => '10+', 'label' => 'Countries Operating'],
        ],
        'specs' => [
            '✓ Triaxial measurement (X, Y, Z)',
            '✓ Frequency: ↑16 kHz',
            '✓ Amplitude: ↑64 g’s',
            '✓ Lines: up to 6400',
            '✓ Structure: 316 stainless steel + nylon',
            '✓ Wi‑Fi communication',
            '✓ Long‑lasting rechargeable battery (up to 3 years)',
            '✓ App and sensor updates included',
            '✓ PDM Monitor + PDM Director platform included',
            '✓ Acceleration (g), velocity, and displacement measurements',
            '✓ Included analysis: FFT, Waveform, Envelope (NanoShock), Configurable frequency bands, Orbit, Waveform Sound',
        ],
        'steps' => [
            [
                'number' => '01',
                'title' => 'Fast & Flexible Installation',
                'description' => 'Install in minutes using magnetic, bolt, or adhesive mounting — no wiring, no infrastructure, and no production downtime required.',
            ],
            [
                'number' => '02',
                'title' => 'No Servers. No Gateways. No Extra Costs.',
                'description' => 'Connect directly to your plant Wi‑Fi — no dedicated servers or specialized gateways required, reducing implementation costs and complexity.',
            ],
            [
                'number' => '03',
                'title' => 'Smart Platform & AI Diagnostics',
                'description' => 'Integrated with PDM Monitor and PDM Director, delivering analytics, automated alerts, and AI‑assisted diagnostics for faster decisions.',
            ],
        ],
    ],
    'v200' => [
        'badge' => 'PRODUCT',
        'title' => 'PDM Tracker — V200',
        'subtitle' => 'Portable inspections and on‑demand data collection designed for real industrial environments.',
        'image' => '/images/v200.png',
        'stats' => [
            ['value' => '5,000+', 'label' => 'Assets Monitored'],
            ['value' => '310+', 'label' => 'Industrial Sensors Installed'],
            ['value' => '10+', 'label' => 'Countries Operating'],
        ],
        'specs' => [
            '✓ Triaxial measurement (X, Y, Z)',
            '✓ Frequency: ↑16 kHz',
            '✓ Amplitude: ↑64 g’s',
            '✓ Lines: up to 6400',
            '✓ Structure: 316 stainless steel + nylon',
            '✓ Wi‑Fi communication',
            '✓ Long‑lasting rechargeable battery (up to 1 week)',
            '✓ Android APP | Apple',
            '✓ PDM Monitor + PDM Director platform included',
            '✓ Acceleration (g), velocity, and displacement measurements',
            '✓ Included analysis: FFT, Waveform, Envelope (NanoShock), Configurable frequency bands, Orbit, Waveform Sound',
        ],
        'steps' => [
            [
                'number' => '01',
                'title' => 'Instant Start',
                'description' => 'Power on and connect instantly to Android or iOS — no complex configuration required.',
            ],
            [
                'number' => '02',
                'title' => 'Recharge & Go',
                'description' => 'Recharge with USB‑C and operate for up to a full week on a single charge.',
            ],
            [
                'number' => '03',
                'title' => 'Fast & Efficient Data Collection',
                'description' => 'Capture vibration data in seconds with a portable triaxial collector, integrated for instant analysis.',
            ],
        ],
    ],
];

const HOME_SERVICES = [
    ['title' => 'Vibration Analysis', 'description' => 'Condition-based diagnostics using vibration signatures of rotating assets.', 'image' => '/images/2022/03/02/analise.jpg', 'href' => '/our-services/vibration-analysis', 'code' => 'VA'],
    ['title' => 'Oil Analysis', 'description' => 'Lubricant and wear-particle analysis for early fault detection in mechanical systems.', 'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&q=80', 'href' => '/our-services/oil-analysis', 'code' => 'OA'],
    ['title' => 'Infrared Thermography', 'description' => 'Infrared inspection to map thermal anomalies in electrical and mechanical assets.', 'image' => '/images/2022/03/02/termografia-1.jpg', 'href' => '/our-services/infrared-thermography', 'code' => 'IT'],
    ['title' => 'Laser Alignment', 'description' => 'Precision shaft alignment to reduce vibration, wear, and energy losses.', 'image' => '/images/services/alignment11.jpg', 'href' => '/our-services/laser-alignment', 'code' => 'LA'],
    ['title' => 'Dynamic Balancing', 'description' => 'On-site balancing of rotors to improve reliability and operational stability.', 'image' => '/images/services/balancing.jpg', 'href' => '/our-services/dynamic-balancing', 'code' => 'DB'],
    ['title' => 'Noise Evaluation', 'description' => 'Instrumented acoustic surveys for compliance, diagnosis, and risk reduction.', 'image' => '/images/services/noise.webp', 'href' => '/our-services/noise-evaluation', 'code' => 'NE'],
];

const CLIENT_LOGOS = [
    '/images/logos/ATD.png',
    '/images/logos/Cemex.png',
    '/images/logos/disney.png',
    '/images/logos/mallinckrodt.png',
    '/images/logos/poliplex.png',
    '/images/logos/valpak.png',
];

const HOME_STATS = [
    ['label' => 'HAPPY CLIENTS', 'value' => '763'],
    ['label' => 'PROBLEMS SOLVED', 'value' => '6480'],
    ['label' => 'SERVICES DELIVERED', 'value' => '13208'],
    ['label' => 'AWARDS', 'value' => '6'],
];

const HOME_FEATURES = [
    ['eyebrow' => 'CERTIFICATION', 'title' => 'Company accredited by Inmetro', 'desc' => 'We operate with a validated technical methodology, traceability, and a compliance focus.'],
    ['eyebrow' => 'TECHNOLOGY', 'title' => 'State-of-the-art equipment', 'desc' => 'Accurate field readings for predictive maintenance, inspection, and agile decision-making.'],
    ['eyebrow' => 'EXPERIENCE', 'title' => 'Team with real factory experience', 'desc' => 'Professionals prepared to operate safely, on schedule, and to a high execution standard.'],
    ['eyebrow' => 'RESULTS', 'title' => 'Performance focused on operational continuity', 'desc' => 'Our work reduces unplanned downtime and increases asset reliability.'],
];

const HOME_DIFFERENTIALS = [
    ['label' => 'Customer Satisfaction', 'value' => '98%'],
    ['label' => 'On-Time Delivery', 'value' => '100%'],
    ['label' => 'Service Satisfaction', 'value' => '99%'],
    ['label' => 'Would Recommend CORELUSA', 'value' => '93%'],
];

const TIMELINE_ITEMS = [
    ['year' => '2005', 'title' => 'Operations started', 'description' => 'CORELUSA began operations focused on predictive maintenance and specialized industrial inspection.'],
    ['year' => '2012', 'title' => 'Technical expansion', 'description' => 'Portfolio expanded with new diagnostic solutions and broader national coverage.'],
    ['year' => '2018', 'title' => 'Field consolidation', 'description' => 'Support for more complex operations with mature technical analysis and support processes.'],
    ['year' => 'Today', 'title' => 'Continuity-driven operation', 'description' => 'A structure focused on reliability, failure prevention, and fast response for critical environments.'],
];

const SERVICE_CONTENT = [
    'vibration-analysis' => [
        'title' => 'VIBRATION ANALYSIS',
        'summary' => 'Condition monitoring of rotating equipment through spectral and temporal vibration diagnostics.',
        'image' => '/images/2022/03/02/analise.jpg',
        'content' => <<<'HTML'
<p>Vibration Analysis identifies mechanical defects at an early stage by measuring amplitude, frequency, and phase behavior of rotating assets. This service supports reliability-centered maintenance by enabling planned intervention before faults evolve into unplanned shutdowns.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Methodology and diagnostic workflow</h3>
<p>Our technicians perform route-based and critical-point measurements using calibrated accelerometers and velocity sensors, followed by FFT spectrum analysis, waveform interpretation, and trend correlation. The diagnostic process distinguishes typical fault signatures such as unbalance, misalignment, bearing defects, looseness, and resonance.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Key technical benefits</h3>
<p>With periodic trending and severity classification, the maintenance team can prioritize corrective actions by risk, reduce emergency interventions, and improve asset availability while extending component life.</p>
<ul class="list-disc space-y-1 pl-6">
  <li>Spectral analysis (FFT) with fault-frequency correlation</li>
  <li>Overall vibration severity assessment by machine class</li>
  <li>Bearing-condition and lubrication-related vibration indicators</li>
  <li>Trend reports with alarm and danger thresholds</li>
  <li>Diagnosis of unbalance, misalignment, and mechanical looseness</li>
  <li>Corrective action recommendations with maintenance priority</li>
</ul>
HTML,
    ],
    'oil-analysis' => [
        'title' => 'OIL ANALYSIS',
        'summary' => 'Tribological and physicochemical analysis of lubricants to assess machine health and contamination.',
        'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&q=80',
        'content' => <<<'HTML'
<p>Oil Analysis evaluates lubricant condition, wear generation, and contamination sources in engines, gearboxes, compressors, and hydraulic systems. It is a high-value predictive tool because the lubricant carries measurable evidence of internal machine degradation long before catastrophic failure.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">How the analysis is performed</h3>
<p>Representative samples are collected under controlled procedures and submitted to laboratory tests such as viscosity, oxidation, water content, particle count, and elemental spectroscopy. Results are interpreted against baseline data and operating context to classify failure modes and lubrication risk.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Operational benefits for reliability programs</h3>
<p>The output supports data-driven maintenance decisions, optimizes oil-change intervals, and prevents secondary damage caused by contamination or inadequate lubricant performance.</p>
<ul class="list-disc space-y-1 pl-6">
  <li>Viscosity and additive depletion monitoring</li>
  <li>Wear-metal trend analysis (Fe, Cu, Al, Cr and others)</li>
  <li>Contamination detection: water, dust, fuel, and coolant ingress</li>
  <li>ISO cleanliness classification for hydraulic circuits</li>
  <li>Lubrication interval optimization based on condition</li>
  <li>Failure-mode investigation with technical recommendations</li>
</ul>
HTML,
    ],
    'infrared-thermography' => [
        'title' => 'INFRARED THERMOGRAPHY',
        'summary' => 'Non-contact thermal inspection for early detection of electrical and mechanical anomalies.',
        'image' => '/images/2022/03/02/termografia-1.jpg',
        'content' => <<<'HTML'
<p>Infrared Thermography captures and quantifies thermal patterns in energized and operating assets, making it possible to detect abnormal heating without interrupting production. This technique is essential to prevent failures, fires, and energy losses in critical installations.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Inspection methodology</h3>
<p>Certified thermographers collect calibrated thermograms, apply emissivity and reflected-temperature corrections, and classify anomalies by thermal delta and criticality. Each finding is validated against load condition and process context to avoid false positives.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Benefits for safety and continuity</h3>
<p>Thermographic campaigns reduce unplanned outages, improve electrical safety, and provide objective evidence for maintenance planning in both electrical and mechanical systems.</p>
<ul class="list-disc space-y-1 pl-6">
  <li>Inspection of panels, breakers, busbars, and cable terminations</li>
  <li>Detection of loose connections, overload, and phase imbalance</li>
  <li>Thermal diagnosis of bearings, couplings, and friction points</li>
  <li>Severity ranking with temperature-delta criteria</li>
  <li>Illustrated report with thermograms and corrective recommendations</li>
  <li>Baseline creation for periodic trend comparison</li>
</ul>
HTML,
    ],
    'laser-alignment' => [
        'title' => 'LASER ALIGNMENT',
        'summary' => 'Precision shaft alignment using laser systems to control angular and offset misalignment.',
        'image' => '/images/services/alignment11.jpg',
        'content' => <<<'HTML'
<p>Laser Alignment corrects shaft position between driver and driven machines to minimize mechanical stress, vibration, and premature wear. Accurate alignment directly impacts bearing life, seal integrity, and power transmission efficiency.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">How alignment is executed</h3>
<p>Using dual-laser and digital inclinometer systems, we measure horizontal and vertical offset, angular deviation, and soft-foot conditions. Corrections are applied through controlled shimming and lateral adjustment until values meet acceptance tolerances.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Performance and maintenance gains</h3>
<p>Proper alignment reduces dynamic loading across rotating trains, lowering maintenance frequency and stabilizing process performance under continuous operation.</p>
<ul class="list-disc space-y-1 pl-6">
  <li>Alignment of motor-pump, motor-gearbox, and fan trains</li>
  <li>Soft-foot inspection and structural correction support</li>
  <li>Thermal growth compensation in critical assets</li>
  <li>Alignment tolerance verification with as-found/as-left records</li>
  <li>Reduction of seal leakage and coupling failures</li>
  <li>Technical report with adjustment history and final geometry</li>
</ul>
HTML,
    ],
    'dynamic-balancing' => [
        'title' => 'DYNAMIC BALANCING',
        'summary' => 'In-situ balancing of rotating components to reduce vibration and improve mechanical stability.',
        'image' => '/images/services/balancing.jpg',
        'content' => <<<'HTML'
<p>Dynamic Balancing removes mass-distribution asymmetry in rotors operating at speed, reducing vibration levels and fatigue loading. The service is critical for fans, blowers, turbines, and other rotating equipment where imbalance drives repetitive mechanical stress.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Balancing procedure</h3>
<p>We perform phase-referenced measurements, determine correction vectors, and execute one-plane or two-plane balancing according to rotor geometry. Trial weights and final correction masses are validated with post-correction vibration readings.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Reliability impact</h3>
<p>Balanced rotors run with lower vibration and bearing load, resulting in improved uptime, lower energy consumption, and longer component service life.</p>
<ul class="list-disc space-y-1 pl-6">
  <li>Field balancing for fans, impellers, and coupled rotors</li>
  <li>Single-plane and two-plane balancing strategies</li>
  <li>Pre- and post-balancing vibration verification</li>
  <li>Correction-mass calculation with traceable methodology</li>
  <li>Support for resonance and structural response review</li>
  <li>Final report with achieved vibration reduction</li>
</ul>
HTML,
    ],
    'noise-evaluation' => [
        'title' => 'NOISE EVALUATION',
        'summary' => 'Quantitative acoustic assessment for occupational exposure control and equipment diagnostics.',
        'image' => '/images/services/noise.webp',
        'content' => <<<'HTML'
<p>Noise Evaluation measures and analyzes sound-pressure levels in industrial environments to support compliance, worker protection, and root-cause diagnosis of noisy equipment. Acoustic data is essential for mitigating risk and improving workplace conditions.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Assessment methodology</h3>
<p>Measurements are performed with calibrated sound level meters and dosimeters using standardized weighting and time-response settings. Survey points are defined by process criticality, occupancy profile, and source proximity to build representative noise maps.</p>
<h3 class="mb-3 mt-6 text-xl font-bold text-text-main">Applications and deliverables</h3>
<p>The evaluation supports compliance strategies, engineering controls, and maintenance actions to reduce acoustic exposure and improve overall operational safety.</p>
<ul class="list-disc space-y-1 pl-6">
  <li>Area noise mapping for production and utility zones</li>
  <li>Personal exposure dosimetry for high-risk roles</li>
  <li>Identification of dominant noise sources by equipment group</li>
  <li>Comparison against applicable occupational criteria</li>
  <li>Recommendations for enclosure, damping, and isolation</li>
  <li>Technical report with measurement logs and action plan</li>
</ul>
HTML,
    ],
];
