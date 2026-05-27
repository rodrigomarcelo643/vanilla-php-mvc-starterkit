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
            <h1 class="text-3xl sm:text-4xl font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight mb-3">Terms of Service</h1>
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
                    'acceptance'       => 'Acceptance of Terms',
                    'use-license'      => 'Use License',
                    'user-accounts'    => 'User Accounts',
                    'prohibited'       => 'Prohibited Activities',
                    'intellectual'     => 'Intellectual Property',
                    'third-party'      => 'Third-Party Links',
                    'disclaimer'       => 'Disclaimer of Warranties',
                    'liability'        => 'Limitation of Liability',
                    'indemnification'  => 'Indemnification',
                    'termination'      => 'Termination',
                    'changes'          => 'Changes to Terms',
                    'governing-law'    => 'Governing Law',
                    'contact'          => 'Contact Us',
                ];
                foreach ($toc as $id => $label): ?>
                    <li>
                        <a href="#<?= $id ?>" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 underline-offset-4 hover:underline transition-colors"><?= $label ?></a>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>

        <!-- Preamble -->
        <div class="mb-10 p-5 rounded-xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50">
            <p class="text-sm text-amber-800 dark:text-amber-300 leading-relaxed">
                <strong>Please read these Terms carefully.</strong> By accessing or using <?= APP_NAME ?>, you confirm that you have read, understood, and agree to be bound by these Terms of Service. If you do not agree with any part of these terms, you may not access our service.
            </p>
        </div>

        <!-- Sections -->
        <div class="space-y-10">

            <!-- 1 -->
            <section id="acceptance" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">1</span>
                    Acceptance of Terms
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>These Terms of Service ("Terms") constitute a legally binding agreement between you ("User," "you," or "your") and <?= APP_NAME ?> ("Company," "we," "us," or "our") governing your access to and use of our website, application, and related services (collectively, the "Service").</p>
                    <p>By creating an account, clicking "I agree," or otherwise accessing or using our Service, you acknowledge that you have read and agree to these Terms. If you are using the Service on behalf of an organization, you represent that you have authority to bind that organization to these Terms.</p>
                    <p>You must be at least <strong class="text-zinc-700 dark:text-zinc-300">13 years of age</strong> to use this Service. By using the Service, you represent that you meet this age requirement.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 2 -->
            <section id="use-license" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">2</span>
                    Use License
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>Subject to your compliance with these Terms, we grant you a limited, non-exclusive, non-transferable, revocable license to access and use the Service for your personal or internal business purposes.</p>
                    <p>You may not:</p>
                    <ul class="list-disc list-inside space-y-1.5 pl-4">
                        <li>Copy, modify, or distribute any portion of the Service or its content</li>
                        <li>Reverse engineer, decompile, or disassemble any software component of the Service</li>
                        <li>Use the Service in any way that violates applicable laws or regulations</li>
                        <li>Sublicense, sell, resell, transfer, or assign your rights under these Terms</li>
                        <li>Use any automated means to access the Service without our prior written consent</li>
                    </ul>
                    <p>This license terminates automatically if you violate any of these restrictions. Upon termination, you must destroy any downloaded materials in your possession.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 3 -->
            <section id="user-accounts" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">3</span>
                    User Accounts
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>When you create an account with us, you must provide accurate, complete, and current information. You are responsible for:</p>
                    <ul class="list-disc list-inside space-y-1.5 pl-4">
                        <li>Maintaining the confidentiality of your account credentials</li>
                        <li>All activities that occur under your account</li>
                        <li>Notifying us immediately of any unauthorized use of your account</li>
                        <li>Ensuring your contact information remains up to date</li>
                    </ul>
                    <p>We reserve the right to terminate accounts, remove or edit content, or cancel orders at our sole discretion. You may not use another person's account without permission.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 4 -->
            <section id="prohibited" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">4</span>
                    Prohibited Activities
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>You agree not to engage in any of the following activities while using the Service:</p>
                    <ul class="list-disc list-inside space-y-1.5 pl-4">
                        <li>Using the Service for any unlawful purpose or in violation of any regulations</li>
                        <li>Harassing, abusing, insulting, harming, or discriminating against any person</li>
                        <li>Submitting false or misleading information</li>
                        <li>Uploading or transmitting viruses, malware, or any other malicious code</li>
                        <li>Interfering with or circumventing the security features of the Service</li>
                        <li>Collecting or harvesting personally identifiable information from the Service</li>
                        <li>Spamming, phishing, or engaging in other deceptive practices</li>
                        <li>Impersonating any person or entity, or falsely stating your affiliation with a person or entity</li>
                    </ul>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 5 -->
            <section id="intellectual" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">5</span>
                    Intellectual Property
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>The Service and its original content, features, and functionality are and will remain the exclusive property of <?= APP_NAME ?> and its licensors. The Service is protected by copyright, trademark, and other laws.</p>
                    <p>Our trademarks and trade dress may not be used in connection with any product or service without the prior written consent of <?= APP_NAME ?>. Any feedback, suggestions, or ideas you provide to us may be used by us without any obligation to you.</p>
                    <p>You retain ownership of any content you submit to the Service. By submitting content, you grant us a worldwide, royalty-free license to use, reproduce, and display that content solely for the purpose of operating the Service.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 6 -->
            <section id="third-party" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">6</span>
                    Third-Party Links
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>The Service may contain links to third-party websites or services that are not owned or controlled by <?= APP_NAME ?>. We have no control over, and assume no responsibility for, the content, privacy policies, or practices of any third-party websites.</p>
                    <p>We strongly advise you to read the terms and privacy policies of any third-party sites you visit. We do not warrant the offerings of any of these entities or their websites.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 7 -->
            <section id="disclaimer" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">7</span>
                    Disclaimer of Warranties
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>THE SERVICE IS PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS WITHOUT ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT.</p>
                    <p>We do not warrant that: (a) the Service will function uninterrupted or error-free; (b) any errors or defects will be corrected; (c) the Service or its servers are free of viruses or other harmful components; or (d) the results of using the Service will meet your requirements.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 8 -->
            <section id="liability" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">8</span>
                    Limitation of Liability
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, IN NO EVENT SHALL <?= strtoupper(APP_NAME) ?>, ITS DIRECTORS, EMPLOYEES, PARTNERS, AGENTS, SUPPLIERS, OR AFFILIATES BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, INCLUDING WITHOUT LIMITATION, LOSS OF PROFITS, DATA, USE, GOODWILL, OR OTHER INTANGIBLE LOSSES.</p>
                    <p>Our total liability to you for any claims arising out of or relating to these Terms or the Service shall not exceed the amount you paid us, if any, in the twelve (12) months preceding the event giving rise to the liability.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 9 -->
            <section id="indemnification" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">9</span>
                    Indemnification
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed pl-8">
                    <p>You agree to defend, indemnify, and hold harmless <?= APP_NAME ?> and its licensors, employees, contractors, agents, officers, and directors from any and all claims, damages, obligations, losses, liabilities, costs, or debt, and expenses (including attorney's fees), arising from: (i) your use of the Service; (ii) your violation of any term of these Terms; or (iii) your violation of any third-party right, including any copyright, property, or privacy right.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 10 -->
            <section id="termination" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">10</span>
                    Termination
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>We may terminate or suspend your account and access to the Service immediately, without prior notice or liability, for any reason, including if you breach these Terms.</p>
                    <p>Upon termination, your right to use the Service will cease immediately. If you wish to terminate your account, you may do so by contacting us or using the account deletion feature available in your settings. All provisions of these Terms which by their nature should survive termination shall survive.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 11 -->
            <section id="changes" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">11</span>
                    Changes to Terms
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>We reserve the right to modify or replace these Terms at any time at our sole discretion. If a revision is material, we will provide at least <strong class="text-zinc-700 dark:text-zinc-300">30 days' notice</strong> prior to any new terms taking effect.</p>
                    <p>What constitutes a material change will be determined at our sole discretion. By continuing to access or use the Service after revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 12 -->
            <section id="governing-law" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">12</span>
                    Governing Law
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed space-y-3 pl-8">
                    <p>These Terms shall be governed and construed in accordance with applicable laws, without regard to its conflict of law provisions.</p>
                    <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions will remain in effect.</p>
                </div>
            </section>

            <hr class="border-zinc-100 dark:border-zinc-800">

            <!-- 13 -->
            <section id="contact" class="scroll-mt-20">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-3 flex items-center gap-2">
                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold flex items-center justify-center">13</span>
                    Contact Us
                </h2>
                <div class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed pl-8">
                    <p>If you have any questions about these Terms, please contact us:</p>
                    <div class="mt-4 p-4 rounded-lg bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 space-y-1.5">
                        <p><strong class="text-zinc-700 dark:text-zinc-300">Application:</strong> <?= APP_NAME ?></p>
                        <p><strong class="text-zinc-700 dark:text-zinc-300">Website:</strong> <a href="<?= BASE_URL ?>" class="text-zinc-900 dark:text-zinc-100 underline underline-offset-2 hover:opacity-75 transition-opacity"><?= BASE_URL ?></a></p>
                    </div>
                </div>
            </section>

        </div><!-- /sections -->

        <!-- Footer nav -->
        <div class="mt-14 pt-8 border-t border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-zinc-400 dark:text-zinc-500">&copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="<?= BASE_URL ?>/privacy" class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors underline-offset-2 hover:underline">Privacy Policy</a>
                <a href="<?= BASE_URL ?>/login"   class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors underline-offset-2 hover:underline">Sign In</a>
                <a href="<?= BASE_URL ?>/register" class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors underline-offset-2 hover:underline">Register</a>
            </div>
        </div>

    </div>
</div>
