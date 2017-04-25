<?php

namespace PdfGenesis\DocumentBundle\Event;

final class DocumentBundleEvents
{
    const SAVE_DOCUMENT = "document_events.save_document";
    const GENERATE_DOCUMENT = "document_events.generate_document";
    const CLEAR_DOCUMENT = "document_events.clear_document";
}