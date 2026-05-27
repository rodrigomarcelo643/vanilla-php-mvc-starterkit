<div class="min-h-screen bg-white dark:bg-zinc-950 fade-in">

    <!-- Top bar -->
    <header class="sticky top-0 z-30 h-14 flex items-center justify-between px-6 sm:px-10 border-b border-zinc-100 dark:border-zinc-800 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-sm">
        <a href="<?= BASE_URL ?>/" class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-md bg-zinc-900 dark:bg-zinc-100 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-white dark:text-zinc-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100"><?= APP_NAME ?></span>
        </a>
        <a href="<?= BASE_URL ?>/login"
           class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Login
        </a>
    </header>

    <!-- Page layout -->
    <div class="max-w-4xl mx-auto px-6 sm:px-10 py-14">

        <!-- Page header -->
        <div class="mb-10 pb-8 border-b border-zinc-200 dark:border-zinc-800">
            <span class="inline-block text-xs font-medium tracking-widest uppercase text-zinc-400 dark:text-zinc-500 mb-3">Legal</span>
            <h1 class="text-3xl sm:text-4xl font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight mb-3">Privacy Policy</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Effective date: <strong class="text-zinc-700 dark:text-zinc-300"><?= date('F j, Y') ?></strong> &nbsp;·&nbsp;
                Last updated: <strong class="text-zinc-700 dark:text-zinc-300"><?= date('F j, Y') ?></strong>
            </p>
        </div>

        <!-- Quick navigation -->
        <nav class="mb-10 p-5 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 dark:text-zinc-500 mb-3">Table of Contents</p>
            <ol class="grid sm:grid-cols-2 gap-x-8 gap-y-1.5 list-decimal list-inside">
                <?php
                $toc = [
                    'information-we-collect' => 'Information We Collect',
                    'how-we-use'             => 'How We Use Your Information',
                    'information-sharing'    => 'Information Sharing',
                    'cookies'                => 'Cookies & Tracking',
                    'data-security'          => 'Data Security',
                    'your-rights'            => 'Your Rights',
                    'data-retention'         => 'Data Retention',
                    'third-party'            => 'Third-Party Services',
                    'children'               => "Children's Privacy",
                    'international'          => 'International Transfers',
                    'changes'                => 'Changes to This Policy',
                    'contact'                => 'Contact Us',
                ];
                foreach ($toc as $id => $label): ?>
                    <li>
                        <a href="#<?= $id ?>" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 underline-offset-4 hover:underline transition-colors"><?= $label ?></a>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>

        <!-- Preamble -->
        <div class="mb-10 p-5 rounded-xl bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800/50">
            <p class="text-sm text-blue-800 dark:text-blue-300 leading-relaxed">
                <strong>Your privacy matters.</strong> This Privacy Policy explains how <?= APP_NAME ?> collects, uses, and protects your personal information when you use our Service. By using the Service you agree to the collection and use of information in accordance with this policy.
            </p>
        </div>

        <!-- Sections -->
        <div class="space-y-10">

            <?php
            $num = 1;
            $sections = [
                [
                    'id'    => 'information-we-collect',
                    'title' => 'Information We Collect',
                    'body'  => '
                        <p>We collect information you provide directly to us and information generated automatically when you use the Service.</p>
                        <p class="font-medium text-zinc-700 dark:text-zinc-300 mt-4">Information you provide:</p>
                        <ul class="list-disc list-inside space-y-1.5 pl-4">
                            <li><strong>Account information</strong> — name, email address, and password when you register</li>
                            <li><strong>Profile information</strong> — optional details such as a profile picture or bio</li>
                            <li><strong>Communications</strong> — messages or feedback you send to us</li>
                        </ul>
                        <p class="font-medium text-zinc-700 dark:text-zinc-300 mt-4">Information collected automatically:</p>
                        <ul class="list-disc list-inside space-y-1.5 pl-4">
                            <li><strong>Log data</strong> — IP address, browser type, pages visited, time and date of visits</li>
                            <li><strong>Device information</strong> — hardware model, operating system, unique device identifiers</li>
                            <li><strong>Cookies and similar technologies</strong> — see the Cookies section below</li>
                        </ul>
                    ',
                ],
                [
                    'id'    => 'how-we-use',
                    'title' => 'How We Use Your Information',
                    'body'  => '
                        <p>We use the information we collect for the following purposes:</p>
                        <ul class="list-disc list-inside space-y-1.5 pl-4">
                            <li>To provide, operate, and maintain the Service</li>
                            <li>To create and manage your account and authenticate you</li>
                            <li>To send transactional emails (e.g., password resets, account confirmations)</li>
                            <li>To respond to your comments, questions, and customer service requests</li>
                            <li>To monitor and analyze usage trends and improve the Service</li>
                            <li>To detect, prevent, and address technical issues and fraudulent activity</li>
                            <li>To comply with legal obligations</li>
                        </ul>
                        <p class="mt-3">We will never sell your personal information to third parties.</p>
                    ',
                ],
                [
                    'id'    => 'information-sharing',
                    'title' => 'Information Sharing',
                    'body'  => '
                        <p>We do not share your personal information with third parties except in the following circumstances:</p>
                        <ul class="list-disc list-inside space-y-1.5 pl-4">
                            <li><strong>Service providers</strong> — trusted vendors who assist us in operating the Service (e.g., hosting, email delivery) under strict confidentiality agreements</li>
                            <li><strong>Legal requirements</strong> — when required by law, court order, or governmental authority</li>
                            <li><strong>Protection of rights</strong> — to protect the rights, property, or safety of <?= APP_NAME ?>, our users, or the public</li>
                            <li><strong>Business transfers</strong> — in connection with a merger, acquisition, or sale of assets, with appropriate notice to you</li>
                            <li><strong>With your consent</strong> — in any other case, only with your explicit consent</li>
                        </ul>
                    ',
                ],
                [
                    'id'    => 'cookies',
                    'title' => 'Cookies & Tracking',
                    'body'  => '
                        <p>We use cookies and similar tracking technologies to track activity on the Service and hold certain information. Cookies are small data files stored on your device.</p>
                        <p class="font-medium text-zinc-700 dark:text-zinc-300 mt-4">Types of cookies we use:</p>
                        <ul class="list-disc list-inside space-y-1.5 pl-4">
                            <li><strong>Essential cookies</strong> — required for the Service to function (e.g., session management, CSRF protection)</li>
                            <li><strong>Preference cookies</strong> — remember your settings such as dark mode preference</li>
                            <li><strong>Analytics cookies</strong> — help us understand how you interact with the Service</li>
                        </ul>
                        <p class="mt-3">You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, disabling essential cookies may prevent some features from working correctly.</p>
                    ',
                ],
                [
                    'id'    => 'data-security',
                    'title' => 'Data Security',
                    'body'  => '
                        <p>We implement industry-standard security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include:</p>
                        <ul class="list-disc list-inside space-y-1.5 pl-4">
                            <li>Encrypted data transmission using HTTPS/TLS</li>
                            <li>Bcrypt password hashing — passwords are never stored in plain text</li>
                            <li>CSRF token protection on all state-changing requests</li>
                            <li>Regular security reviews and dependency updates</li>
                        </ul>
                        <p class="mt-3">While we strive to protect your information, no method of transmission over the Internet or electronic storage is 100% secure. We cannot guarantee absolute security.</p>
                    ',
                ],
                [
                    'id'    => 'your-rights',
                    'title' => 'Your Rights',
                    'body'  => '
                        <p>Depending on your location, you may have the following rights regarding your personal information:</p>
                        <ul class="list-disc list-inside space-y-1.5 pl-4">
                            <li><strong>Access</strong> — request a copy of the personal data we hold about you</li>
                            <li><strong>Correction</strong> — request correction of inaccurate or incomplete data</li>
                            <li><strong>Deletion</strong> — request deletion of your personal data ("right to be forgotten")</li>
                            <li><strong>Portability</strong> — receive your data in a structured, machine-readable format</li>
                            <li><strong>Objection</strong> — object to certain processing of your data</li>
                            <li><strong>Restriction</strong> — request restriction of processing in certain circumstances</li>
                        </ul>
                        <p class="mt-3">To exercise any of these rights, please contact us using the details in the Contact section. We will respond within 30 days.</p>
                    ',
                ],
                [
                    'id'    => 'data-retention',
                    'title' => 'Data Retention',
                    'body'  => '
                        <p>We retain your personal information for as long as your account is active or as needed to provide the Service. We will also retain and use your information to comply with our legal obligations, resolve disputes, and enforce our agreements.</p>
                        <p class="mt-3">When you delete your account, we will delete or anonymize your personal information within <strong class="text-zinc-700 dark:text-zinc-300">30 days</strong>, unless retention is required by law.</p>
                    ',
                ],
                [
                    'id'    => 'third-party',
                    'title' => 'Third-Party Services',
                    'body'  => '
                        <p>The Service may integrate with third-party services such as OAuth providers (Google, GitHub). These services have their own privacy policies, and we encourage you to review them. We are not responsible for the privacy practices of third-party services.</p>
                        <p class="mt-3">When you connect a third-party account, we may receive certain profile information from that provider as permitted by your privacy settings on that service.</p>
                    ',
                ],
                [
                    'id'    => 'children',
                    'title' => "Children's Privacy",
                    'body'  => '
                        <p>The Service is not directed to individuals under the age of <strong class="text-zinc-700 dark:text-zinc-300">13</strong>. We do not knowingly collect personal information from children under 13. If we become aware that a child under 13 has provided us with personal information, we will take steps to delete such information promptly.</p>
                        <p class="mt-3">If you believe a child under 13 has provided information to us, please contact us immediately.</p>
                    ',
                ],
                [
                    'id'    => 'international',
                    'title' => 'International Transfers',
                    'body'  => '
                        <p>Your information may be transferred to — and maintained on — computers located outside of your state, province, country, or other governmental jurisdiction where data protection laws may differ from those in your jurisdiction.</p>
                        <p class="mt-3">If you are located outside the jurisdiction where our servers are hosted and choose to provide information to us, please note that we transfer the information to our servers and process it there. Your submission of such information represents your agreement to that transfer.</p>
                    ',
                ],
                [
                    'id'    => 'changes',
                    'title' => 'Changes to This Policy',
                    'body'  => '
                        <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date at the top.</p>
                        <p class="mt-3">You are advised to review this Privacy Policy periodically for any changes. Changes are effective when they are posted on this page. For material changes, we will provide at least <strong class="text-zinc-700 dark:text-zinc-300">30 days\' notice</strong> by email or prominent notice on the Service.</p>
                    ',
                ],
                [
                    'id'    => 'contact',
                    'title' => 'Contact Us',
                    'body'  => '
                        <p>If you have any questions or concerns about this Privacy Policy or our data practices, please contact us:</p>
                        <div class="mt-4 p-4 rounded-lg bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 space-y-1.5">
                            <p><strong class="text-zinc-700 dark:text-zinc-300">Application:</strong> ' . APP_NAME . '</p>
                            <p><strong class="text-zinc-700 dark:text-zinc-300">Website:</strong> <a href="' . BASE_URL . '" class="text-zinc-900 dark:text-zinc-100 underline underline-offset-2 hover:opacity-75 transition-opacity">' . BASE_URL . '</a></p>
                        </div>
                    ',
                ],
            ];
            foreach ($sections as $s):
            ?>
            <section id="<?= $s['id'] ?>" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center"><?= $num++ ?></span>
                    <?= $s['title'] ?>
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-2 pl-8">
                    <?= $s['body'] ?>
                </div>
            </section>
            <?php if ($num <= count($sections) + 1): ?>
            <hr class="border-zinc-100 dark:border-zinc-800">
            <?php endif; endforeach; ?>

        </div><!-- /sections -->

        <!-- Footer nav -->
        <div class="mt-14 pt-8 border-t border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-zinc-400 dark:text-zinc-500">&copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="<?= BASE_URL ?>/terms"    class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors underline-offset-2 hover:underline">Terms of Service</a>
                <a href="<?= BASE_URL ?>/login"    class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors underline-offset-2 hover:underline">Sign In</a>
                <a href="<?= BASE_URL ?>/register" class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors underline-offset-2 hover:underline">Register</a>
            </div>
        </div>

    </div>
</div>
