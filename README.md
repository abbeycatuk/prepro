# prepro

prepro is a simple preprocessor, allowing for a set of centralised constant 
definitions to be substituted into a project's source files.

## Code Example

prepro requires two configuration files before it can be invoked - a 
definitions file, and a configuration file.

### Definitions
The definitions follows essentially a C-like syntax and identifies all 
constants (one per line) that prepro is to consider during preprocessing.

The example below identifies a definitions file (prepro.def) that associates 
the constant "MAX_USERNAME_LENGTH" with the value "20":

```
; define an example constant
#define MAX_USERNAME_LENGTH 20
```

### Configuration
The configuration file provides a simple mapping that tells prepro which 
file types it should look for, and what affix each constant will be 
surrounded by.

The example below identifies a configuration file (prepro.ini) that implies 
prepro should only consider .php, .phtml, .js and .ini files for 
preprocessing, and that constants identified in prepro.def will be found with 
"\__" affixes (i.e. "MAX_USERNAME_LENGTH" will be 
"\__MAX_USERNAME_LENGTH__"):

```
[mappings]
php,phtml,js,ini = "__"
```

With the definitions and configuration available, prepro can be invoked 
against a source folder and told to output the preprocessed results into an 
output folder like this:

```bash
$ prepro --input pre --output source --config prepro.ini --preprocess prepro.def
```

## Motivation

Some projects gather various technologies, frameworks and languages that 
operate across various layers. In these projects, certain constants can end up 
being defined repeatedly throughout, and changing them requires diligence 
to ensure all references have been captured and changed correctly.

prepro moves to allow for a central definition of such constants, and to 
have these substituted at the source level (prior to any existing build 
process), helping to ensure that a change to a definition can be quickly, 
correctly and reliably propagated throughout the project.

## Installation

It is simplest to use [Composer](https://getcomposer.org/) to download 
and install prepro.

## License

This project is licensed under MIT. See the LICENSE file for more details.

## Contribute

Contributions, whatever their nature, are welcomed.
