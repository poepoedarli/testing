@extends('developer.index')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
@endsection
{{--<style>--}}
{{--    /* 去除选中题目的背景色 */--}}
{{--    .nav-main-item.open .nav-main-link {--}}
{{--        background-color: transparent !important;--}}
{{--    }--}}

{{--    .nav-main-submenu {--}}
{{--        background-color: transparent !important;--}}
{{--    }--}}
{{--</style>--}}

<style>
    .markdown-preview {
        width: 100%;
        height: 100%;
        box-sizing: border-box
    }

    .markdown-preview .pagebreak, .markdown-preview .newpage {
        page-break-before: always
    }

    .markdown-preview pre.line-numbers {
        position: relative;
        padding-left: 3.8em;
        counter-reset: linenumber
    }

    .markdown-preview pre.line-numbers > code {
        position: relative
    }

    .markdown-preview pre.line-numbers .line-numbers-rows {
        position: absolute;
        pointer-events: none;
        top: 1em;
        font-size: 100%;
        left: 0;
        width: 3em;
        letter-spacing: -1px;
        border-right: 1px solid #999;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none
    }

    .markdown-preview pre.line-numbers .line-numbers-rows > span {
        pointer-events: none;
        display: block;
        counter-increment: linenumber
    }

    .markdown-preview pre.line-numbers .line-numbers-rows > span:before {
        content: counter(linenumber);
        color: #999;
        display: block;
        padding-right: .8em;
        text-align: right
    }

    .markdown-preview .mathjax-exps .MathJax_Display {
        text-align: center !important
    }

    .markdown-preview:not([for="preview"]) .code-chunk .btn-group {
        display: none
    }

    .markdown-preview:not([for="preview"]) .code-chunk .status {
        display: none
    }

    .markdown-preview:not([for="preview"]) .code-chunk .output-div {
        margin-bottom: 16px
    }

    .markdown-preview .md-toc {
        padding: 0
    }

    .markdown-preview .md-toc .md-toc-link-wrapper .md-toc-link {
        display: inline;
        padding: .25rem 0
    }

    .markdown-preview .md-toc .md-toc-link-wrapper .md-toc-link p, .markdown-preview .md-toc .md-toc-link-wrapper .md-toc-link div {
        display: inline
    }

    .markdown-preview .md-toc .md-toc-link-wrapper.highlighted .md-toc-link {
        font-weight: 800
    }

    .scrollbar-style::-webkit-scrollbar {
        width: 8px
    }

    .scrollbar-style::-webkit-scrollbar-track {
        border-radius: 10px;
        background-color: transparent
    }

    .scrollbar-style::-webkit-scrollbar-thumb {
        border-radius: 5px;
        background-color: rgba(150, 150, 150, 0.66);
        border: 4px solid rgba(150, 150, 150, 0.66);
        background-clip: content-box
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode]) {
        position: relative;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        margin: 0;
        padding: 0;
        overflow: auto
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode]) .markdown-preview {
        position: relative;
        top: 0
    }

    @media screen and (min-width: 914px) {
        .markdown-content[for="html-export"]:not([data-presentation-mode]) .markdown-preview {
            /*padding: 2em calc(50% - 457px + 2em)*/
        }
    }

    @media screen and (max-width: 914px) {
        .markdown-content[for="html-export"]:not([data-presentation-mode]) .markdown-preview {
            padding: 2em
        }
    }

    @media screen and (max-width: 450px) {
        .markdown-content[for="html-export"]:not([data-presentation-mode]) .markdown-preview {
            font-size: 14px !important;
            padding: 1em
        }
    }

    @media print {
        .markdown-content[for="html-export"]:not([data-presentation-mode]) #sidebar-toc-btn {
            display: none
        }
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode]) #sidebar-toc-btn {
        position: fixed;
        bottom: 8px;
        left: 8px;
        font-size: 28px;
        cursor: pointer;
        color: inherit;
        z-index: 99;
        width: 32px;
        text-align: center;
        opacity: .4
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] #sidebar-toc-btn {
        opacity: 1
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc {
        position: fixed;
        top: 0;
        left: 0;
        width: 300px;
        height: 100%;
        padding: 32px 0 48px 0;
        font-size: 14px;
        box-shadow: 0 0 4px rgba(150, 150, 150, 0.33);
        box-sizing: border-box;
        overflow: auto;
        background-color: inherit
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar {
        width: 8px
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar-track {
        border-radius: 10px;
        background-color: transparent
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc::-webkit-scrollbar-thumb {
        border-radius: 5px;
        background-color: rgba(150, 150, 150, 0.66);
        border: 4px solid rgba(150, 150, 150, 0.66);
        background-clip: content-box
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc a {
        text-decoration: none
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc .md-toc {
        padding: 0 16px
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc .md-toc .md-toc-link-wrapper .md-toc-link {
        display: inline;
        padding: .25rem 0
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc .md-toc .md-toc-link-wrapper .md-toc-link p, .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc .md-toc .md-toc-link-wrapper .md-toc-link div {
        display: inline
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .md-sidebar-toc .md-toc .md-toc-link-wrapper.highlighted .md-toc-link {
        font-weight: 800
    }

    .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview {
        left: 300px;
        width: calc(100% - 300px);
        padding: 2em calc(50% - 457px - 300px / 2);
        margin: 0;
        box-sizing: border-box
    }

    @media screen and (max-width: 1274px) {
        .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview {
            padding: 2em
        }
    }

    @media screen and (max-width: 450px) {
        .markdown-content[for="html-export"]:not([data-presentation-mode])[html-show-sidebar-toc] .markdown-preview {
            width: 100%
        }
    }

    /*.markdown-content[for="html-export"]:not([data-presentation-mode]):not([html-show-sidebar-toc]) .markdown-preview {*/
    /*    left: 50%;*/
    /*    transform: translateX(-50%)*/
    /*}*/

    .markdown-content[for="html-export"]:not([data-presentation-mode]):not([html-show-sidebar-toc]) .md-sidebar-toc {
        display: none
    }

    /**
     * prism.js Github theme based on GitHub's theme.
     * @author Sam Clarke
     */
    code[class*="language-"],
    pre[class*="language-"] {
        color: #333;
        background: none;
        font-family: Consolas, "Liberation Mono", Menlo, Courier, monospace;
        text-align: left;
        white-space: pre;
        word-spacing: normal;
        word-break: normal;
        word-wrap: normal;
        line-height: 1.4;

        -moz-tab-size: 8;
        -o-tab-size: 8;
        tab-size: 8;

        -webkit-hyphens: none;
        -moz-hyphens: none;
        -ms-hyphens: none;
        hyphens: none;
    }

    /* Code blocks */
    pre[class*="language-"] {
        padding: .8em;
        overflow: auto;
        /* border: 1px solid #ddd; */
        border-radius: 3px;
        /* background: #fff; */
        background: #f5f5f5;
    }

    /* Inline code */
    :not(pre) > code[class*="language-"] {
        padding: .1em;
        border-radius: .3em;
        white-space: normal;
        background: #f5f5f5;
    }

    .token.comment,
    .token.blockquote {
        color: #969896;
    }

    .token.cdata {
        color: #183691;
    }

    .token.doctype,
    .token.punctuation,
    .token.variable,
    .token.macro.property {
        color: #333;
    }

    .token.operator,
    .token.important,
    .token.keyword,
    .token.rule,
    .token.builtin {
        color: #a71d5d;
    }

    .token.string,
    .token.url,
    .token.regex,
    .token.attr-value {
        color: #183691;
    }

    .token.property,
    .token.number,
    .token.boolean,
    .token.entity,
    .token.atrule,
    .token.constant,
    .token.symbol,
    .token.command,
    .token.code {
        color: #0086b3;
    }

    .token.tag,
    .token.selector,
    .token.prolog {
        color: #63a35c;
    }

    .token.function,
    .token.namespace,
    .token.pseudo-element,
    .token.class,
    .token.class-name,
    .token.pseudo-class,
    .token.id,
    .token.url-reference .token.variable,
    .token.attr-name {
        color: #795da3;
    }

    .token.entity {
        cursor: help;
    }

    .token.title,
    .token.title .token.punctuation {
        font-weight: bold;
        color: #1d3e81;
    }

    .token.list {
        color: #ed6a43;
    }

    .token.inserted {
        background-color: #eaffea;
        color: #55a532;
    }

    .token.deleted {
        background-color: #ffecec;
        color: #bd2c00;
    }

    .token.bold {
        font-weight: bold;
    }

    .token.italic {
        font-style: italic;
    }


    /* JSON */
    .language-json .token.property {
        color: #183691;
    }

    .language-markup .token.tag .token.punctuation {
        color: #333;
    }

    /* CSS */
    code.language-css,
    .language-css .token.function {
        color: #0086b3;
    }

    /* YAML */
    .language-yaml .token.atrule {
        color: #63a35c;
    }

    code.language-yaml {
        color: #183691;
    }

    /* Ruby */
    .language-ruby .token.function {
        color: #333;
    }

    /* Markdown */
    .language-markdown .token.url {
        color: #795da3;
    }

    /* Makefile */
    .language-makefile .token.symbol {
        color: #795da3;
    }

    .language-makefile .token.variable {
        color: #183691;
    }

    .language-makefile .token.builtin {
        color: #0086b3;
    }

    /* Bash */
    .language-bash .token.keyword {
        color: #0086b3;
    }

    /* highlight */
    pre[data-line] {
        position: relative;
        padding: 1em 0 1em 3em;
    }

    pre[data-line] .line-highlight-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        background-color: transparent;
        display: block;
        width: 100%;
    }

    pre[data-line] .line-highlight {
        position: absolute;
        left: 0;
        right: 0;
        padding: inherit 0;
        margin-top: 1em;
        background: hsla(24, 20%, 50%, .08);
        background: linear-gradient(to right, hsla(24, 20%, 50%, .1) 70%, hsla(24, 20%, 50%, 0));
        pointer-events: none;
        line-height: inherit;
        white-space: pre;
    }

    pre[data-line] .line-highlight:before,
    pre[data-line] .line-highlight[data-end]:after {
        content: attr(data-start);
        position: absolute;
        top: .4em;
        left: .6em;
        min-width: 1em;
        padding: 0 .5em;
        background-color: hsla(24, 20%, 50%, .4);
        color: hsl(24, 20%, 95%);
        font: bold 65%/1.5 sans-serif;
        text-align: center;
        vertical-align: .3em;
        border-radius: 999px;
        text-shadow: none;
        box-shadow: 0 1px white;
    }

    pre[data-line] .line-highlight[data-end]:after {
        content: attr(data-end);
        top: auto;
        bottom: .4em;
    }

    .emoji {
        height: 0.8em;
    }

    .markdown-content {
        font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, freesans, sans-serif;
        font-size: 13px;
        line-height: 1.6;
        color: #333;
        background-color: #fff;
        overflow: initial;
        box-sizing: border-box;
        word-wrap: break-word
    }

    .markdown-content > :first-child {
        margin-top: 0
    }

    .markdown-content h1, .markdown-content h2, .markdown-content h3, .markdown-content h4, .markdown-content h5, .markdown-content h6 {
        line-height: 1.2;
        margin-top: 1em;
        margin-bottom: 16px;
        color: #000
    }

    .markdown-content h1 {
        font-size: 2.25em;
        font-weight: 300;
        padding-bottom: .3em
    }

    .markdown-content h2 {
        font-size: 1.75em;
        font-weight: 400;
        padding-bottom: .3em
    }

    .markdown-content h3 {
        font-size: 1.5em;
        font-weight: 500
    }

    .markdown-content h4 {
        font-size: 1.25em;
        font-weight: 600
    }

    .markdown-content h5 {
        font-size: 1.1em;
        font-weight: 600
    }

    .markdown-content h6 {
        font-size: 1em;
        font-weight: 600
    }

    .markdown-content h1, .markdown-content h2, .markdown-content h3, .markdown-content h4, .markdown-content h5 {
        font-weight: 600
    }

    .markdown-content h5 {
        font-size: 1em
    }

    .markdown-content h6 {
        color: #5c5c5c
    }

    .markdown-content strong {
        color: #000
    }

    .markdown-content del {
        color: #5c5c5c
    }

    .markdown-content a:not([href]) {
        color: inherit;
        text-decoration: none
    }

    .markdown-content a {
        color: #08c;
        text-decoration: none
    }

    .markdown-content a:hover {
        color: #00a3f5;
        text-decoration: none
    }

    .markdown-content img {
        max-width: 100%
    }

    .markdown-content > p {
        margin-top: 0;
        margin-bottom: 16px;
        word-wrap: break-word
    }

    .markdown-content > ul, .markdown-content > ol {
        margin-bottom: 16px
    }

    .markdown-content ul, .markdown-content ol {
        padding-left: 2em
    }

    .markdown-content ul.no-list, .markdown-content ol.no-list {
        padding: 0;
        list-style-type: none
    }

    .markdown-content ul ul, .markdown-content ul ol, .markdown-content ol ol, .markdown-content ol ul {
        margin-top: 0;
        margin-bottom: 0
    }

    .markdown-content li {
        margin-bottom: 0
    }

    .markdown-content li.task-list-item {
        list-style: none
    }

    .markdown-content li > p {
        margin-top: 0;
        margin-bottom: 0
    }

    .markdown-content .task-list-item-checkbox {
        margin: 0 .2em .25em -1.8em;
        vertical-align: middle
    }

    .markdown-content .task-list-item-checkbox:hover {
        cursor: pointer
    }

    .markdown-content blockquote {
        margin: 16px 0;
        font-size: inherit;
        padding: 0 15px;
        color: #5c5c5c;
        background-color: #f0f0f0;
        border-left: 4px solid #d6d6d6
    }

    .markdown-content blockquote > :first-child {
        margin-top: 0
    }

    .markdown-content blockquote > :last-child {
        margin-bottom: 0
    }

    .markdown-content hr {
        height: 4px;
        margin: 32px 0;
        background-color: #d6d6d6;
        border: 0 none
    }

    .markdown-content table {
        margin: 10px 0 15px 0;
        border-collapse: collapse;
        border-spacing: 0;
        display: block;
        width: 100%;
        overflow: auto;
        word-break: normal;
        word-break: keep-all
    }

    .markdown-content table th {
        font-weight: bold;
        color: #000
    }

    .markdown-content table td, .markdown-content table th {
        border: 1px solid #d6d6d6;
        padding: 6px 13px
    }

    .markdown-content dl {
        padding: 0
    }

    .markdown-content dl dt {
        padding: 0;
        margin-top: 16px;
        font-size: 1em;
        font-style: italic;
        font-weight: bold
    }

    .markdown-content dl dd {
        padding: 0 16px;
        margin-bottom: 16px
    }

    .markdown-content code {
        font-family: Menlo, Monaco, Consolas, 'Courier New', monospace;
        font-size: .85em !important;
        color: #000;
        background-color: #f0f0f0;
        border-radius: 3px;
        padding: .2em 0
    }

    .markdown-content code::before, .markdown-content code::after {
        letter-spacing: -0.2em;
        content: "\00a0"
    }

    .markdown-content pre > code {
        padding: 0;
        margin: 0;
        font-size: .85em !important;
        word-break: normal;
        white-space: pre;
        background: transparent;
        border: 0
    }

    .markdown-content .highlight {
        margin-bottom: 16px
    }

    .markdown-content .highlight pre, .markdown-content pre {
        padding: 1em;
        overflow: auto;
        font-size: .85em !important;
        line-height: 1.45;
        border: #d6d6d6;
        border-radius: 3px
    }

    .markdown-content .highlight pre {
        margin-bottom: 0;
        word-break: normal
    }

    .markdown-content pre code, .markdown-content pre tt {
        display: inline;
        max-width: initial;
        padding: 0;
        margin: 0;
        overflow: initial;
        line-height: inherit;
        word-wrap: normal;
        background-color: transparent;
        border: 0
    }

    .markdown-content pre code:before, .markdown-content pre tt:before, .markdown-content pre code:after, .markdown-content pre tt:after {
        content: normal
    }

    .markdown-content p, .markdown-content blockquote, .markdown-content ul, .markdown-content ol, .markdown-content dl, .markdown-content pre {
        margin-top: 0;
        margin-bottom: 16px
    }

    .markdown-content kbd {
        color: #000;
        border: 1px solid #d6d6d6;
        border-bottom: 2px solid #c7c7c7;
        padding: 2px 4px;
        background-color: #f0f0f0;
        border-radius: 3px
    }

    @media print {
        .markdown-content {
            background-color: #fff
        }

        .markdown-content h1, .markdown-content h2, .markdown-content h3, .markdown-content h4, .markdown-content h5, .markdown-content h6 {
            color: #000;
            page-break-after: avoid
        }

        .markdown-content blockquote {
            color: #5c5c5c
        }

        .markdown-content pre {
            page-break-inside: avoid
        }

        .markdown-content table {
            display: table
        }

        .markdown-content img {
            display: block;
            max-width: 100%;
            max-height: 100%
        }

        .markdown-content pre, .markdown-content code {
            word-wrap: break-word;
            white-space: pre
        }
    }

    /* Please visit the URL below for more information: */
    /*   https://shd101wyy.github.io/markdown-preview-enhanced/#/customize-css */

</style>

@section('developer-content')
    {{--    <div class="row" style="overflow-y: auto;height: 600px">--}}
    {{--        <div class="col-md-3">--}}
    {{--            <div class="js-sidebar-scroll">--}}
    {{--                <!-- Side Navigation -->--}}
    {{--                <div class="content-side content-side-full">--}}
    {{--                    Coming Soon--}}
    {{--                    <ul class="nav-main" >--}}
    {{--                        @foreach($list as $category)--}}
    {{--                            <li class="nav-main-item">--}}
    {{--                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"--}}
    {{--                                   aria-haspopup="true"--}}
    {{--                                   aria-expanded="true" href="#">--}}
    {{--                                    <span class="nav-main-link-name"><b>{{$category['name']}}</b></span>--}}
    {{--                                </a>--}}
    {{--                                <ul class="nav-main-submenu">--}}
    {{--                                    @foreach($category['contents'] as $content)--}}
    {{--                                        <li class="">--}}
    {{--                                            <a href="#"  onclick="getContent({{$content['id']}})" style="color: black">--}}
    {{--                                                <span >{{$content['title']}}</span>--}}
    {{--                                            </a>--}}
    {{--                                        </li>--}}
    {{--                                        <span style="display: none"--}}
    {{--                                              id="doc-content-{{$content['id']}}">{!!$content['content']!!}</span>--}}
    {{--                                    @endforeach--}}
    {{--                                </ul>--}}
    {{--                            </li>--}}
    {{--                        @endforeach--}}
    {{--                    </ul>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="col-md-9" id="doc-content">--}}
    {{--            {!!$list[0]['contents'][0]['content'] ?? '' !!}--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="markdown-content px-2">
        <div class="mume markdown-preview">
            <div>
                <h2 class="mume-header" id="1-overview" ebook-toc-level-2 heading="1. Overview">1. Overview</h2>

                <p>AI Platform is a development platform designed to provide developers with encapsulation and support
                    for core
                    services, making it easier to build and deploy artificial intelligence applications. This document
                    will
                    introduce the main features and usage of AI Platform, helping developers to quickly get started and
                    implement their business logic.</p>
                <h2 class="mume-header" id="2-developers-guide" ebook-toc-level-2
                    heading="2. Developer&amp;apos;s Guide">2.
                    Developer&apos;s Guide</h2>

                <h3 class="mume-header" id="introduction-to-basic-services" ebook-toc-level-3
                    heading="Introduction to Basic Services:">Introduction to Basic Services:</h3>

                <ol>
                    <li>Each core service is encapsulated as an independent module and can be used through a simple
                        API.
                    </li>
                    <li>The framework handles dependencies between modules and initializes the relevant module
                        parameters
                        through configuration.
                    </li>
                    <li>The modules are designed to be plug-and-play, and developers can enable them as needed.</li>
                </ol>
                <h3 class="mume-header" id="implementation-of-developers-business-logic" ebook-toc-level-3
                    heading="Implementation of Developer&amp;apos;s Business Logic:">Implementation of Developer&apos;s
                    Business
                    Logic:</h3>

                <ol>
                    <li>Call the core service API provided by the framework for development.</li>
                    <li>The core services handle the basic work, allowing developers to focus on business needs.</li>
                </ol>
                <h3 class="mume-header" id="continuous-expansion-of-core-service-modules" ebook-toc-level-3
                    heading="Continuous Expansion of Core Service Modules:">Continuous Expansion of Core Service
                    Modules:</h3>

                <ol>
                    <li>The framework development team continuously adds new service modules.</li>
                    <li>Modular design makes expansion more flexible.</li>
                </ol>
                <h2 class="mume-header" id="3-capabilities-introduction" ebook-toc-level-2
                    heading="3. Capabilities Introduction">3. Capabilities Introduction</h2>

                <h3 class="mume-header" id="basic-services" ebook-toc-level-3 heading="Basic Services">Basic
                    Services</h3>

                <ol>
                    <li>OCR
                        <ul>
                            <li>Wafer batch number recognition</li>
                            <li>General OCR API</li>
                        </ul>
                    </li>
                    <li>Defect Detection
                        <ul>
                            <li>Wafer crack detection</li>
                            <li>Wafer missing detection</li>
                            <li>Automatic defect classification</li>
                            <li>And more</li>
                        </ul>
                    </li>
                </ol>
                <h3 class="mume-header" id="applications" ebook-toc-level-3 heading="Applications">Applications</h3>

                <ol>
                    <li>Build applications based on supported services on the platform.</li>
                </ol>
                <h2 class="mume-header" id="4-operation-guide" ebook-toc-level-2 heading="4. Operation Guide">4.
                    Operation
                    Guide</h2>

                <ol>
                    <li>Create an application
                        <ol>
                            <li>Select one or more basic services for application creation.</li>
                        </ol>
                    </li>
                    <li>Upload data, train models</li>
                    <li>Test and analyze application results</li>
                    <li>Deploy the application</li>
                </ol>
                <h2 class="mume-header" id="5-api-documentation" ebook-toc-level-2 heading="5. API Documentation">5. API
                    Documentation</h2>

                <h3 class="mume-header" id="1-ocr" ebook-toc-level-3 heading="1. OCR">1. OCR</h3>

                <ul>
                    <li>GRPC 1</li>
                </ul>
                <h3 class="mume-header" id="2-auto-defect-detection" ebook-toc-level-3
                    heading="2. Auto Defect Detection">2.
                    Auto Defect Detection</h3>

                <ul>
                    <li>GRPC 1</li>
                    <li>GRPC 2</li>
                </ul>
                <h3 class="mume-header" id="3-general-interface" ebook-toc-level-3 heading="3. General Interface">3.
                    General
                    Interface</h3>

                <pre data-role="codeBlock" data-info="markdown" class="language-markdown"><span
                            class="token title important"><span
                                class="token punctuation">##</span> Table of Contents</span>

<span class="token list punctuation">-</span> <span class="token url">[<span
                                class="token content">Service Manage API</span>](<span
                                class="token url">#ai_service-proto</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">GetServiceConfigRequest</span>](<span
                                class="token url">#ai_service_api-GetServiceConfigRequest</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">GetServiceConfigResponse</span>](<span
                                class="token url">#ai_service_api-GetServiceConfigResponse</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ServiceCallRequest</span>](<span
                                class="token url">#ai_service_api-ServiceCallRequest</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ServiceCallResponse</span>](<span
                                class="token url">#ai_service_api-ServiceCallResponse</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ServiceStartRequest</span>](<span
                                class="token url">#ai_service_api-ServiceStartRequest</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ServiceStartResponse</span>](<span
                                class="token url">#ai_service_api-ServiceStartResponse</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ServiceStatusRequest</span>](<span
                                class="token url">#ai_service_api-ServiceStatusRequest</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ServiceStatusResponse</span>](<span
                                class="token url">#ai_service_api-ServiceStatusResponse</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ServiceStopRequest</span>](<span
                                class="token url">#ai_service_api-ServiceStopRequest</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ServiceStopResponse</span>](<span
                                class="token url">#ai_service_api-ServiceStopResponse</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">UpdateServiceConfigRequest</span>](<span
                                class="token url">#ai_service_api-UpdateServiceConfigRequest</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">UpdateServiceConfigResponse</span>](<span
                                class="token url">#ai_service_api-UpdateServiceConfigResponse</span>)</span>
<span class="token list punctuation">-</span> <span class="token url">[<span class="token content">Other Message</span>](<span
                                class="token url">#ai_service-proto</span>)</span>
    <span class="token list punctuation">-</span> <span class="token url">[<span class="token content">ImageData</span>](<span
                                class="token url">#ai_service_api-ImageData</span>)</span>

<span class="token title important"><span class="token punctuation">##</span> ai_service.proto</span>

The <span class="token code-snippet code keyword">`ai_service.proto`</span> file defines the structure of the API for the AI Service.

<span class="token title important"><span class="token punctuation">###</span> GetServiceConfigRequest</span>

The <span class="token code-snippet code keyword">`GetServiceConfigRequest`</span> message is used to request the current configuration of the AI service.

<span class="token table"><span class="token table-header-row"><span class="token punctuation">|</span><span
                class="token table-header important"> Field </span><span class="token punctuation">|</span><span
                class="token table-header important"> Type </span><span class="token punctuation">|</span><span
                class="token table-header important"> Label </span><span class="token punctuation">|</span><span
                class="token table-header important"> Description </span><span class="token punctuation">|</span>
</span><span class="token table-line"><span class="token punctuation">|</span> <span
                class="token punctuation">-----</span> <span class="token punctuation">|</span> <span
                class="token punctuation">----</span> <span
                class="token punctuation">|</span> <span class="token punctuation">-----</span> <span
                class="token punctuation">|</span> <span
                class="token punctuation">-----------</span> <span class="token punctuation">|</span>
</span><span class="token table-data-rows"><span class="token punctuation">|</span><span class="token table-data"> version </span><span
                class="token punctuation">|</span><span class="token table-data"> <span class="token url">[<span
                        class="token content">string</span>](<span class="token url">#string</span>)</span> </span><span
                class="token punctuation">|</span><span class="token table-data">  </span><span
                class="token punctuation">|</span><span class="token table-data"> The version of the service for which the configuration is being requested. </span><span
                class="token punctuation">|</span>
</span></span>
<span class="token title important"><span class="token punctuation">###</span> GetServiceConfigResponse</span>

The <span class="token code-snippet code keyword">`GetServiceConfigResponse`</span> message returns the current configuration of the AI service.

<span class="token table"><span class="token table-header-row"><span class="token punctuation">|</span><span
                class="token table-header important"> Field </span><span class="token punctuation">|</span><span
                class="token table-header important"> Type </span><span class="token punctuation">|</span><span
                class="token table-header important"> Label </span><span class="token punctuation">|</span><span
                class="token table-header important"> Description </span><span class="token punctuation">|</span>
</span><span class="token table-line"><span class="token punctuation">|</span> <span
                class="token punctuation">-----</span> <span class="token punctuation">|</span> <span
                class="token punctuation">----</span> <span
                class="token punctuation">|</span> <span class="token punctuation">-----</span> <span
                class="token punctuation">|</span> <span
                class="token punctuation">-----------</span> <span class="token punctuation">|</span>
</span><span class="token table-data-rows"><span class="token punctuation">|</span><span class="token table-data"> service_config </span><span
                class="token punctuation">|</span><span class="token table-data"> <span class="token url">[<span
                        class="token content">bytes</span>](<span class="token url">#bytes</span>)</span> </span><span
                class="token punctuation">|</span><span class="token table-data">  </span><span
                class="token punctuation">|</span><span class="token table-data"> The current configuration of the service, in a serialized binary format. </span><span
                class="token punctuation">|</span>
</span></span>
<span class="token title important"><span class="token punctuation">###</span> ServiceCallRequest</span>

The <span class="token code-snippet code keyword">`ServiceCallRequest`</span> message is used to send an image processing request to the AI service.

<span class="token table"><span class="token table-header-row"><span class="token punctuation">|</span><span
                class="token table-header important"> Field </span><span class="token punctuation">|</span><span
                class="token table-header important"> Type </span><span class="token punctuation">|</span><span
                class="token table-header important"> Label </span><span class="token punctuation">|</span><span
                class="token table-header important"> Description </span><span class="token punctuation">|</span>
</span><span class="token table-line"><span class="token punctuation">|</span> <span
                class="token punctuation">-----</span> <span class="token punctuation">|</span> <span
                class="token punctuation">----</span> <span
                class="token punctuation">|</span> <span class="token punctuation">-----</span> <span
                class="token punctuation">|</span> <span
                class="token punctuation">-----------</span> <span class="token punctuation">|</span>
</span><span class="token table-data-rows"><span class="token punctuation">|</span><span class="token table-data"> service_name </span><span
                class="token punctuation">|</span><span class="token table-data"> <span class="token url">[<span
                        class="token content">string</span>](<span class="token url">#string</span>)</span> </span><span
                class="token punctuation">|</span><span class="token table-data">  </span><span
                class="token punctuation">|</span><span class="token table-data"> The name</span>
</span></span>
</pre>
                <h2 class="mume-header" id="6-troubleshooting" ebook-toc-level-2 heading="6. Troubleshooting">6.
                    Troubleshooting</h2>

            </div>
        </div>
    </div>
    <script>

        const clickableItems = document.querySelectorAll('.nav-main-submenu a');

        clickableItems.forEach(item => {
            item.addEventListener('click', function () {
                clickableItems.forEach(item => {
                    item.style.color = 'black';
                });

                this.style.color = 'blue';
            });
        });

        function getContent(id) {
            var spanContent = document.getElementById("doc-content-" + id);
            var content = spanContent.innerHTML;
            var docContent = document.getElementById("doc-content");
            docContent.innerHTML = content
        }
    </script>
@endsection