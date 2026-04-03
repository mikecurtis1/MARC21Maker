# MARC21Maker

**MARC21Maker** is a lightweight PHP implementation for generating valid **MARC21 binary records** from structured input.

This project was created to explore and demonstrate how MARC21 works *at a low level*, without relying on MARCXML or external libraries.

---

## Overview

MARC21 is a legacy bibliographic data format that combines:

* Fixed-length fields (leader)
* Byte-offset directory entries
* Variable-length field data
* Special delimiter characters for fields and subfields

Unlike modern formats (JSON, XML), MARC21 requires strict positional accuracy. Every part of the record must align exactly at the byte level.

This project constructs a complete MARC21 record by assembling these components programmatically.

---

## Why This Project Exists

Most real-world systems interact with MARC data using higher-level abstractions such as MARCXML or existing libraries.

This project was built to:

* Understand the MARC21 binary format directly
* Implement record construction from the specification
* Verify that correct leader and directory values can be generated dynamically

The focus is on correctness of structure rather than abstraction or framework usage.

---

## Key Technical Challenges

### Leader Construction

The MARC21 leader is a fixed 24-character field containing:

* Total record length
* Base address of data
* Encoding and structural metadata

Both the record length and base address must be calculated dynamically and must exactly match the final byte layout of the record.

---

### Directory Offsets

Each field is indexed in the directory using:

* Tag (3 characters)
* Field length (4 digits)
* Starting position (5 digits)

These offsets must align precisely with the position of each field in the record. Any mismatch results in an invalid file.

---

### Delimiters and Control Characters

MARC21 uses non-printable ASCII characters:

* Field terminator → `chr(30)`
* Record terminator → `chr(29)`
* Subfield delimiter → `chr(31)`

These are embedded directly into the output string and must be placed correctly.

---

### Escaped Subfield Handling

The `$` character indicates subfields (e.g. `$aTitle`), but may also appear as literal content.

A custom parser (`EscapeString`) distinguishes:

* `$a` → subfield delimiter
* `\$` → literal dollar sign

This ensures correct encoding of field content.

---

## Example Usage

```php
<?php

require_once('../src/MARC21Maker.php');
require_once('../src/EscapeString.php');

$mrc = new MARC21Maker('n','j','a');
$mrc->addControlField('001','123456789');
$mrc->addDataField('100',' ',' ','$aauthor');
$mrc->addDataField('245',' ',' ','$aTitle With Escaped \$ Dollar Sign');

$mrc->emitMRC();
```

---

## Example Output

The generated output is a binary MARC21 record containing non-printable delimiters. It is intended for use with MARC-compatible tools.

---

## Validation

The generated record was tested using MarcEdit, a widely used MARC utility.

It loaded without errors and was successfully parsed into readable MARC format:

```
=LDR  00120nja a2200061   4500
=001  123456789
=100  \\$aauthor
=245  \\$aTitle With Escaped {dollar} Dollar Sign
```

This confirms that:

* Leader values are correct
* Directory offsets align with field data
* Field and record terminators are valid
* Subfield encoding and escaping behave as expected

---

## UTF-8 Encoding Example

```php
<?php

require_once('../src/MARC21Maker.php');
require_once('../src/EscapeString.php');

$mrc = new MARC21Maker('n','g','m');
$mrc->addControlField('001','123456789');
$mrc->addDataField('100','0',' ','$aAkira Kurosawa (黒澤 明)');
$mrc->addDataField('240','1','0','$aSeven Samurai');
$mrc->addDataField('245',' ',' ','$a七人の侍');
$mrc->addDataField('264',' ','1','$c1954');

$mrc->emitMRC();
```

Output

```
=LDR  00172ngm a2200085   4500
=001  123456789
=100  0\$aAkira Kurosawa (黒澤 明)
=240  10$aSeven Samurai
=245  \\$a七人の侍
=264  \1$c1954
```

---

## Running with Docker

This project has been containerized to provide a consistent runtime environment.

### Clone the repo

```bash
git clone https://github.com/mikecurtis1/MARC21Maker.git
```

### Build the container

```bash
docker build -t marc21maker .
```

### Run the container

```bash
docker run -p 8080:80 -d -v $(pwd):/var/www/html marc21maker
```

Then open:

```
http://localhost:8080
```

to execute the example script.

---

## Project Notes

* This code was originally written as a low-level exploration of MARC21 internals
* It intentionally avoids external libraries to focus on the raw format
* The implementation emphasizes correctness and structure over modern PHP patterns
* The project has been containerized to make it easy to run in a modern environment

---

## Summary

This project demonstrates:

* Implementation of a strict binary/text hybrid format from specification
* Byte-level calculation of record structure
* Directory indexing and offset alignment
* Parsing and handling of escape sequences
* Validation against real-world MARC tooling

---

## MARC21 Resources

* http://www.loc.gov/marc/bibliographic/bdintro.html
* http://www.loc.gov/marc/specifications/specrecstruc.html
* http://www.loc.gov/marc/bibliographic/bdleader.html
* https://www.loc.gov/marc/makrbrkr.html

---

## License

[![License: CC BY-NC-SA 4.0](https://img.shields.io/badge/License-CC%20BY--NC--SA%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by-nc-sa/4.0/)

This project is licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.

---

## Author

Michael Curtis
