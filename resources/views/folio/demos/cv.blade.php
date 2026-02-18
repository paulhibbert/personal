<!DOCTYPE html>
<html lang="en-GB">

<head>
    <title>Paul Hibbert CV</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: "BlinkMacSystemFont", -apple-system, "Segoe UI", "Roboto", "Helvetica", "Arial", "Droid Sans", sans-serif;
            font-size: 16px;
        }

        .grid-container {
            margin: auto;
            width: 90vw;
            display: grid;
        }

        @media (min-width: 800px) {
            .grid-container {
                grid-template-columns: 3fr 5fr;
                grid-gap: 2em;
            }

            .left-hand-side {
                grid-column: 1;
                background-image: linear-gradient(to bottom, rgba(255, 235, 205, 0.4), rgba(255, 204, 128, 0.4)), url("user.svg");
            }

            .right-hand-side {
                grid-column: 2;
            }

            .full-width {
                grid-column: 1/3;
            }
        }

        .left-hand-side {
            text-align: center;
            padding-left: 0.5em;
            padding-right: 0.5em;
        }

        .collapsible-article {
            margin: auto;
            margin-top: 1em;
            width: 100%;
            display: grid;
            background-color: #3f4652;
            border: 0.5px solid #3f4652;
            grid-template-columns: 1fr auto;
            grid-template-rows: auto auto;
        }

        .collapsible-article label {
            grid-column: 1;
            color: white;
            padding-left: 1em;
            padding-top: 0.5em;
            padding-bottom: 0.5em;
            align-self: center;
        }

        .collapsible-article input {
            opacity: 0;
            transform: scale(2.5);
            grid-area: 1/2/1/2;
            padding-right: 1em;
            align-self: center;
        }

        .collapsible-article span {
            grid-area: 1/2/1/2;
            padding-right: 1em;
            align-self: center;
        }

        .collapsible-article div {
            grid-area: 2/1/2/3;
            background-color: blanchedalmond;
            padding-left: 1em;
            padding-right: 1em;
            max-height: 99vh;
            overflow: hidden;
            opacity: 1;
            height: auto;
            transition: opacity 1s linear, max-height 1s linear;
        }

        .collapsible-article input[type="checkbox"]:checked~div {
            opacity: 0;
            max-height: 0;
            border: none;
        }

        .collapsible-article label:before {
            font: 70% sans-serif;
            content: "▼";
            margin-right: .25em;
        }

        .collapsible-article input[type="checkbox"]:checked~label:before {
            content: "";
            margin-right: reset;
        }

        .collapsible-menu {
            position: absolute;
            top: 1em;
            right: 0em;
        }

        .collapsible-menu input {
            opacity: 0;
            transform: scale(2);
            z-index: 3;
            position: absolute;
            right: 2em;
        }

        .collapsible-menu input[type="checkbox"]:checked~ul {
            opacity: 0;
            max-height: 0;
            border: none;
            z-index: -1;
        }

        .collapsible-menu span {
            position: relative;
            left: -1.75em;
            z-index: 2;
        }

        .menu-content {
            position: absolute;
            top: -2em;
            right: 0em;
            background-color: white;
            padding: 1em;
            width: 6em;
            z-index: 1;
            list-style-type: none;
            font-size: larger;
        }

        .menu-content li {
            padding-bottom: 1em;
        }

        .menu-content li a {
            text-decoration: none;
        }

        .feather {
            position: relative;
            top: 0.3em;
        }

        h2:target::before {
            font: 70% sans-serif;
            content: "►";
            margin-right: .25em;
        }

        header ul {
            padding-inline-start: unset;
        }

        header li {
            list-style-type: none;
        }

        .feather-menu line {
            transition: all 250ms ease-in-out;
            transform: rotate(0deg);
            transform-origin: 50% 50%;
            will-change: transform, opacity;
        }

        .collapsible-menu input[type="checkbox"]:not(:checked)~span>svg>line:nth-child(1) {
            opacity: 0;
        }

        .collapsible-menu input[type="checkbox"]:not(:checked)~span>svg>line:nth-child(4) {
            opacity: 0;
        }

        .collapsible-menu input[type="checkbox"]:not(:checked)~span>svg>line:nth-child(2) {
            transform: rotate(45deg);
        }

        .collapsible-menu input[type="checkbox"]:not(:checked)~span>svg>line:nth-child(3) {
            transform: rotate(-45deg);
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 1em;
        }

        .buttons a {
            margin-right: 1em;
            margin-bottom: 1em;
        }

        blockquote {
            border-left: 5px solid orange;
            padding-left: 1em;
            margin-inline-start: 0;
            -webkit-margin-start: 0;
        }

        /*!
            Pure v3.0.0
            Copyright 2013 Yahoo!
            Licensed under the BSD License.
            https://github.com/pure-css/pure/blob/master/LICENSE
        */
        .pure-button {
            display: inline-block;
            line-height: normal;
            white-space: nowrap;
            text-align: center;
            cursor: pointer;
            -webkit-user-select: none;
            user-select: none;
            box-sizing: border-box
        }

        .pure-button {
            font-family: inherit;
            font-size: 100%;
            padding: .5em 1em;
            border: none transparent;
            text-decoration: none;
            border-radius: 2px
        }

        .pure-button:focus,
        .pure-button:hover {
            background-image: linear-gradient(transparent, rgba(0, 0, 0, .05) 40%, rgba(0, 0, 0, .1))
        }

        .pure-button:focus {
            outline: 0
        }

        .pure-button-primary {
            background-color: #0078e7;
            color: #fff
        }
    </style>
</head>

<body>
    <div class="grid-container">
        <nav class="collapsible-menu">
            <input id="hamburger" type="checkbox" checked>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather-menu">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </span>

            <ul class="menu-content">
                <li>
                    <a href="#education">Education</a>
                </li>
                <li>
                    <a href="#experience">Experience</a>
                </li>
                <li>
                    <a href="#proof">Testimonials</a>
                </li>
            </ul>
        </nav>
        <section class="left-hand-side">
            <header>
                <h1>Paul Hibbert</h1>
                <p>Senior Laravel Developer, formerly Head of IT, CTO, Business Manager, Global Account Manager.</p>
                <p>Still Coding, Still Learning</p>
                <h2>Personal Statement</h2>
                <p>I've spent the last decade as a developer building and refactoring complex business applications
                    primarily using the awesome and constantly improving Laravel framework.</p>
                <p>Earlier in my career I've also led teams, delivered major transformation projects, done my time in
                    solution sales and product marketing, served as a CTO for a multinational telecoms business, run my
                    own small business, and even worked behind the scenes in the UK parliament.</p>
                <h2>Skills & Attributes</h2>
                <ul>
                    <li>Problem Solving</li>
                    <li>Business Logic</li>
                    <li>Communication</li>
                    <li>Full Stack developer</li>
                    <li>Leadership</li>
                    <li>Project Management</li>
                </ul>
                <h2>Keywords</h2>
                <ul>
                    <li>Laravel, VueJS</li>
                    <li>Inertia, Precognition, Livewire</li>
                    <li>PHPUnit</li>
                    <li>3rd party API Integration, webhooks, API Development</li>
                    <li>PHP 8.4, HTML, CSS, JS, SQL, Markdown</li>
                    <li>Linux, Windows</li>
                    <li>Git</li>
                </ul>
            </header>
        </section>
        <section class="right-hand-side">
            <h2 id="education">Education
                <span class="feather">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-bell">
                        <path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0">
                        </path>
                    </svg>
                </span>
            </h2>
            <article class="collapsible-article">
                <input id="ccc" type="checkbox" checked>
                <label for="ccc">Corpus Christi College, Oxford</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <p>BA (Hons) Literae Humaniores, First Class</p>
                    <p>1982-1986</p>
                    <p>Greek and Latin Literature, and Philosophy</p>
                    <p>Haigh Scholar</p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="sgs" type="checkbox" checked>
                <label for="sgs">Stockport Grammar School</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <p>1974-1981</p>
                    <p>School Medal, Head of School, 1981</p>
                    <p>GCE S Level: History(1), Latin(2)</p>
                    <p>GCE A Level: History (A), Latin (2), Greek (B), French (B), General Studies (A)</p>
                    <p>GCE O Level: Maths (A), English (B), Eng, Lit. (B), History (B), Geography (A), Latin (A), German
                        (B), Spanish (A), French (A), Biology (A), Woodwork (B)</p>
                </div>
            </article>
            <h2 id="experience">Experience <span class="feather">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-briefcase">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </span>
            </h2>
            <article class="collapsible-article">
                <input id="onbuy" type="checkbox" checked>
                <label for="onbuy">Senior Developer, E-commerce, 2025</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Onbuy</h3>
                    <p>January 2025-March 2026</p>
                    <p>Remote. Fast growing online marketplace. PHP, Laravel, MySQL. Primarily backend. Some vanilla
                        Javascript. Lots of payment integration work. Major redesign of payment flow to increase
                        reliability and reduce the number of steps in the backend to complete a payment. Added
                        significant
                        numbers of new payment methods across Europe. Added additional payment gateway providers. Built
                        new metrics system to track payment success and failure rates in real time.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="skyelarke" type="checkbox" checked>
                <label for="skyelarke">Senior Developer, Clinical Trials Payments, 2023</label>                
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>SkyeLarke</h3>
                    <p>January 2023-October 2024</p>
                    <p>Remote. Start up wholly owned by MDGroup of Bracknell. Laravel application to manage payouts for
                        clinical trials, prepaid cards, bank accounts, Paypal and Venmo accounts. Multi-country,
                        multi-currency, privacy focused. A great deal of work with Inertia and VueJS in addition to
                        complex refactoring and rearchitecting of the initial MVP implementation while maintaining
                        up time and backwards compatibility for existing customers. Entire development team along with
                        QA and project management was made redundant in October 2024 in the third restructing of that
                        year.</p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="reassured" type="checkbox" checked>
                <label for="reassured">Senior Systems Developer, Insurance, 2020</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Reassured (Life Insurance Broker, Basingstoke)</h3>
                    <p>June 2020-December 2022</p>
                    <p>Remote. Part of a team of around 16 developers working using Scrum methodology on high volume,
                        mission critical bespoke CRM. Last project was ahigh availability Laravel application to manage
                        outbound and inbound telephony and call recording.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="lightflows" type="checkbox" checked>
                <label for="lightflows">Web Developer, Agency, 2018</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Lightflows (Digital Agency, Guildford)</h3>
                    <p>October 2018-June 2020</p>
                    <p>Primarily backend developer, PHP & frontend Javascript, serving APIs (Laravel/Lumen),
                        integrations (Sendgrid, Hubspot, Google Data Studio, Google Tag Manager) and middleware
                        (transforming SQL Server & Oracle based client data into ecommerce platforms). WordPress
                        plugins. Laravel Nova. Codeception/Selenium automated testing.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="handpicked" type="checkbox" checked>
                <label for="handpicked">Co-Founder & Business Development Director, 2017</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Hand Picked Clinics</h3>
                    <p>October 2017-August 2020</p>
                    <p>We founded Hand Picked Clinics to provide a bespoke dental and medical tourism service very
                        different
                        from the typical vast database driven approach. We only worked with dentists and doctors with
                        whom
                        we could build a real and trusted relationship so that we could provide honest personalised
                        advice to
                        clients. The Global Pandemic forced a re-evaluation and ultimately closure.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="pharmacy" type="checkbox" checked>
                <label for="pharmacy">Head of IT & Development, E-commerce, 2016</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>White Pharmacy, Farnham, Surrey</h3>
                    <p>January 2016-August 2017</p>
                    <ul>
                        <li>Migrated IT infrastructure from ad-hoc, disorganised legacy to simple maintainence in less
                            than
                            6 months: Office 365, Windows Server 2012 R2, Meraki Firewall, Switches, WiFi AP; 3CX,
                            Slack.</li>
                        <li>Led team of 4, including two developers, one experienced another trained from scratch. Due
                            to
                            small size, extensively hands on across the whole ecosystem.</li>
                        <li>Continuous improvement of front-end website (including a big-bang move to responsive) led to
                            75% increase in sales in first ten months.</li>
                        <li>Continuous improvement of back-end application enabled increased volume to be executed more
                            reliably
                            with the same number of staff. Trustpilot ratings constantly improved up to 9.8 / 10.</li>
                        <li>Technology stack: PHP, MySQL, Centos 6, Jquery, Bootstrap 4, in-house CMS, integrations with
                            Elavon, DPD, Slack, Nexmo (SMS), TimeTap appointments; Incapsula CDN.</li>
                    </ul>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="photographer" type="checkbox" checked>
                <label for="photographer">Professional Photographer, 2007</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Self-Employed, Surrey</h3>
                    <p>January 2007 - December 2015</p>
                    <p>I learned a lot working for myself in a B2C business. I took many thousands of images of families
                        in their own homes, of cute and or troublesome children, of weddings and events. I got my
                        licentiate
                        as a member of the BIPP. I really learned how to use Photoshop! Most importantly I was able to
                        be
                        primary parent to my teenage boys and build a strong relationship with them after missing their
                        early
                        years while I was flying around the world or on endless conference calls.</p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="infonetcto" type="checkbox" checked>
                <label for="infonetcto">Senior Director, Technology Strategy, 2000 (and CTO from 2003)</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Infonet Services Corporation, Los Angeles</h3>
                    <p>2000 - 2006</p>
                    <p>A very productive time working from a combination of my desk in Los Angeles and my desk at home
                        in
                        the UK. Executing the network roll-out following IPO in 2000, and the complete redesign of the
                        network
                        architecture. New products were delivered some more successful and timely than others (including
                        ATM, video transport and conferencing, application defined networking, LAN device management,
                        inbound
                        voice and call centre services, VPNs combining MPLS, IPSEC and SSL site by site). Continued to
                        work
                        on supporting big deals particularly where investment required in network topology, capacity,
                        capabilities
                        or products/services were being stretched. Particular focus on USA led deals at this time,
                        supporting
                        a great sales team. Lots of HQ presentations. From 2004 working on the sale to BT and subsequent
                        integration activities.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="infoneteu" type="checkbox" checked>
                <label for="infoneteu">European Technical Sales Support, 1998</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Infonet Services Corporation EMEA, Brussels</h3>
                    <p>1998 - 2000</p>
                    <p>I was plucked from the UK operation and became sales overlay across all products - mainly data,
                        data+voice,
                        remote access and security. Great time selling QoS before anyone else, combined voice and data
                        that
                        worked before anyone else, and best remote access service at the time. Focussed mainly on
                        supporting
                        sales teams in Germany, Denmark, Finland, UK, France.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="infonetuk" type="checkbox" checked>
                <label for="infonetuk">Head of Solution Engineering, 1995</label>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Infonet UK Limited, Savile Row, London</h3>
                    <p>1995 - 1998</p>
                    <p>This was a great time. Huge learning curve at the start but loved being thrown into the deep end.
                        Selling IP networks when everyone else was selling Frame Relay (though we did a bit of that
                        too).
                        Designing solutions for the likes of Thomas Cook, Rockwell, Standard Chartered, Hasbro etc. Lots
                        of responsibility and a great team. A few firsts like selling voice over data to RBC via COLT.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="perkins" type="checkbox" checked>
                <label for="perkins">Team Leader, Programming & PC/Network Support, 1989</label>                
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>Perkins Engines, Peterborough</h3>
                    <p>1989 - 1995</p>
                    <p>Joined as Computer Programmer, progressed through programmer/analyst, programming team leader.
                        Introduced
                        PC LAN to the business, developed first PC Server (nonmainframe) application, led roll-out of
                        LAN’s
                        to overseas offices, managed entire I.T. infrastructure build for new parts warehouse, developed
                        first CD-ROM/Windows based parts catalogue application for worldwide dealer network, WAN support
                        for global dealer network (X.25). Extensive overseas travel both to sell, train and support
                        dealer
                        systems.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="britishrail" type="checkbox" checked>
                <label for="britishrail">Trainee Programmer, 1988</label>                
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>British Rail, Nottingham</h3>
                    <p>1988 - 1989</p>
                    <p>Assembler & COBOL programming, mainly on reservation systems, for example the addition of
                        disabled
                        seat booking functionality to the main seat reservation program.
                    </p>
                </div>
            </article>
            <article class="collapsible-article">
                <input id="hoc" type="checkbox" checked>
                <label for="hoc">Clerk to Treasury & Civil Service Sub-Committee, 1986</label>                
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather-chevrons-down">
                        <polyline points="7 13 12 18 17 13"></polyline>
                        <polyline points="7 6 12 11 17 6"></polyline>
                    </svg>
                </span>
                <div>
                    <h3>House of Commons, London</h3>
                    <p>1986 - 1988</p>
                    <p>Duties included gathering evidence and drafting reports for House of Commons Select Committees,
                        initially
                        for Scottish Affairs and then Treasury & Civil Service Committee. Principal author of seminal
                        report
                        on Civil Service Reform.
                    </p>
                </div>
            </article>
        </section>
        <section class="full-width">
            <h2 id="proof">Online & Testimonials</h2>
            <div class="buttons">
                <a href="https://www.linkedin.com/in/paul-anthony-hibbert/" target="_blank"
                    class="pure-button pure-button-primary">LinkedIn
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-linkedin">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                        <rect x="2" y="9" width="4" height="12"></rect>
                        <circle cx="4" cy="4" r="2"></circle>
                    </svg>
                </a>
                <a href="https://github.com/paulhibbert" target="_blank" class="pure-button pure-button-primary">Github
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-github">
                        <path
                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                        </path>
                    </svg>
                </a>
                <a href="https://www.freecodecamp.org/fccdf169600-23b1-4cc5-853d-1a26d35bde6b" target="_blank"
                    class="pure-button pure-button-primary">Certifications
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-check-square">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </a>
                <a href="https://youtu.be/n6YkJk3h_dY" target="_blank" class="pure-button pure-button-primary">Video
                    Testimonial
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-youtube">
                        <path
                            d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                        </path>
                        <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                    </svg>
                </a>
                <a href="https://youtu.be/-B6DWxfdfDw" target="_blank" class="pure-button pure-button-primary">Video
                    Testimonial
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-youtube">
                        <path
                            d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                        </path>
                        <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                    </svg>
                </a>
                <a href="https://youtu.be/ks7mh3nzk-w" target="_blank" class="pure-button pure-button-primary">Video
                    Testimonial
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-youtube">
                        <path
                            d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                        </path>
                        <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                    </svg>
                </a>
                <a href="https://youtu.be/jYaTJkUlbyQ" target="_blank" class="pure-button pure-button-primary">Video
                    Testimonial
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-youtube">
                        <path
                            d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                        </path>
                        <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                    </svg>
                </a>
                <a href="https://youtu.be/WuKspoyU1So" target="_blank" class="pure-button pure-button-primary">Video
                    Testimonial
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-youtube">
                        <path
                            d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                        </path>
                        <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                    </svg>
                </a>
            </div>
            <blockquote>
                Paul is one of the most effective executives I have known. A great listener and communicator. He is
                intelligent and experienced
                across many functional areas. Paul makes any company better in the broadest sense, he improves focus
                across
                the organization and creates enthusiasm for the potential he sees and all is driven by the customer. A
                great
                person to have on your team.
            </blockquote>
            <cite>Bob Stickney, currently Business Development Director at EnterSolarEDU</cite>
            <blockquote>
                Paul would explain concepts at my level (complete beginner) and gave me challenging tasks to consolidate
                my learning. He
                also made sure to give plenty of encouragement and support along the way. I feel that the one of the
                main
                things that Paul was able to impart was his work ethic - everyone around him at ... was inspired to give
                110% to every task in hand and I am sure his future colleagues will react in the same way.
            </blockquote>
            <cite>Ruth Hazeldine</cite>
            <blockquote>
                Paul is amazing to work with, and has outstanding experience in technology. He understands complicated
                issues even when outside
                of his direct area of expertise. For Paul the job is always the most important thing to do. Paul assumed
                a leadership role in Infonet, inspiring and motivating his colleagues. Result driven, experienced and
                efficient
                team player. Deliver results and move on. That's Paul's way.
            </blockquote>
            <cite>Iris Bossert, currently Senior Account Manager at Fiebig GmBH</cite>
        </section>
    </div>
</body>

</html>