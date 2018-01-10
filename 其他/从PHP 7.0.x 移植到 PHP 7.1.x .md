# 从PHP 7.0.x 移植到 PHP 7.1.x 

## 概述

    这个新的小版本带来了大量的新特性和少量的兼容性调整在生产环境切换PHP版本前应该进行相关测试。
    
**另本机测试环境包含了php 5.6，7.0.*，7.1.*三个版本，如需测试，随时打断。**

## 一、新特性
### 1.1 可为空（Nullable）类型

类型现在允许为空，当启用这个特性时，传入的参数或者函数返回的结果要么是给定的类型，要么是null 。可以通过在类型前面加上一个问号来使之成为可为空的。**同样适用于返回值。**
    
```php
// 作为参数
function test(?string $name) {
    var_dump($name);
}

test('tpunt');  // string(5) "tpunt"
test(null);     // NULL
test();         // Uncaught Error: Too few arguments to function test(), 0 passed in...

// 作为返回值
function test2(): ?int {
    return null; // or return 123; 
}

// 用于接口函数定义
interface Fooable {
    function foo(?Fooable $f);
}
```

> 注意：如果函数本身定义了参数类型并且没有默认值，即使是可空的，也不能省略，否则会触发错误
> test()方法中，如果参数定义为：`?string $name = null` 的形式，则第三种写法也是可行的。因为 = null 实际上相当于 ? 的超集，对于可空类型的参数，可以设定 null 为默认值。

### 1.2 Void 函数
在PHP 7中引入的其他返回值类型的基础上，一个新的返回值类型void被引入。返回值声明为void类型的方法要么干脆省去return语句，要么使用一个空的return语句。 对于void函数来说，null不是一个合法的返回值。
 
```php
function swap(&$left, &$right) : void
{
    if ($left === $right) {
        return;
        return null; // fatal error
        return 1; // fatal error
    }

    $tmp = $left;
    $left = $right;
    $right = $tmp;
}

$a = 1;
$b = 2;
var_dump(swap($a, $b), $a, $b);

试图去获取一个 void 方法的返回值会得到 null ，并且不会产生任何警告。
这么做的原因是不想影响更高层次的方法。
结果：
null
int(2)
int(1)
```

> 注意：void 只适用于返回类型，并不能用于参数类型声明，如果强加会触发错误

```php
function foobar(void $foo) { 
// Fatal error: void cannot be used as a parameter type
    ...
}
```

> 注意：类函数中对于返回类型的声明也不能被子类覆盖，否则会触发错误

```php
class Foo
{
    public function bar(): void {
    }
}

class Foobar extends Foo
{
    public function bar(): array { 
    // Fatal error: Declaration of Foobar::bar() 
    // must be compatible with Foo::bar(): void
    }
}
```

### 1.3 短数组语法(Symmetric array destructuring)

短数组语法（[]）现在可以用于将数组的值赋给一些变量（包括在foreach中）。 这种方式使从数组中提取值变得更为容易。

```php
$data = [
    ['id' => 1, 'name' => 'Tom'],
    ['id' => 2, 'name' => 'Fred'],
];

while (['id' => $id, 'name' => $name] = $data) {
    // logic here with $id and $name
}
```

### 1.4 类常量可见性

0. php7.1 之前的特性
    
    1. 在定义时必须被初始值，
    2. **前面不加任何修饰符**
    3. 变量名字母一般都大写
    4. **常量可以被子类继承**
    5. 一个常量是属于一个类的，而不是某个对象的

1. 支持设置类常量的可见性

    ```php
    class ConstDemo
    {
        // 常量默认为 public
        const PUBLIC_CONST_A = 1; 
        
        // 可以自定义常量的可见范围
        public const PUBLIC_CONST_B = 2;
        protected const PROTECTED_CONST = 3;
        private const PRIVATE_CONST = 4;
        
        // 多个常量同时声明只能有一个属性
        private const FOO = 1, BAR = 2;
    }
    ```
2. 接口（interface）中的常量只能是 public 属性

    ```php
    interface ICache {
        public const PUBLIC = 0;
        const IMPLICIT_PUBLIC = 1;
    }
    ```
3. 为了应对变化，反射类的实现也相应的丰富了一下，增加了 getReflectionConstant 和 getReflectionConstants 两个方法用于获取常量的额外属性

    ```php
    class testClass {
        const TEST_CONST = 'test';
    }
        
    $obj = new ReflectionClass( "testClass" );
    $const = $obj->getReflectionConstant( "TEST_CONST" );
    $consts = $obj->getReflectionConstants();
    
    // 结果
    object(ReflectionClassConstant)#2 (2) {
      ["name"]=>
      string(10) "TEST_CONST"
      ["class"]=>
      string(9) "testClass"
    }
    
    array(1) {
      [0]=>
      object(ReflectionClassConstant)#3 (2) {
        ["name"]=>
        string(10) "TEST_CONST"
        ["class"]=>
        string(9) "testClass"
      }
    }
    ```

### 1.5 iterable 伪类

现在引入了一个新的被称为iterable的伪类 (与callable类似)。 这可以被用在参数或者返回值类型中，它代表接受数组或者实现了Traversable接口的对象。 至于子类，当用作参数时，子类可以收紧父类的iterable类型到array 或一个实现了Traversable的对象。对于返回值，子类可以拓宽父类的 array或对象返回值类型到iterable

它可以被用在参数或者返回值类型中，它代表接受数组或者实现了 Traversable(遍历) 接口的对象。

```php
// 官方实例
function iterator(iterable $iter)
{
    foreach ($iter as $val) {
        //
    }
}

// PHP 5.6
function dump(array $items){
    var_dump($items);
}

dump([2, 3, 4]);
dump(new Collection());

// 结果
array(3) {
  [0]=>
  int(2)
  [1]=>
  int(3)
  [2]=>
  int(4)
}

Catchable fatal error: Argument 1 passed to dump() 
must be of the type array, object given...
```

但在这种情况下，函数不会接受一个价值，将抛出一个错误。这一新的变化，让你使用迭代来描述而不是手动一个价值主张。

```php
// PHP 7.1
function dump(iterable $items){
    var_dump($items);
}

dump([2, 3, 4]);
dump(new Collection());

// 结果
array(3) {
  [0]=>
  int(2)
  [1]=>
  int(3)
  [2]=>
  int(4)
}
object(Collection)#2 (0) {}

```


### 1.6 多异常捕获处理

一个catch语句块现在可以通过管道字符(|)来实现多个异常的捕获。 这对于需要同时处理来自不同类的不同异常时很有用。

```php
// php 7 之前
try {
    // Some code...
} catch (ExceptionType1 $e) {
    // 处理 ExceptionType1
} catch (ExceptionType2 $e) {
    // 处理 ExceptionType2
} catch (\Exception $e) {
    // ...
}

// php 7.1 以后

try {
    // some code
} catch (FirstException | SecondException $e) {
    // handle first and second exceptions
}
```
### 1.7 list()现在支持键名

1. 简化命名

把数组的值赋值给不同的变量，可以通过 list 来实现

```php
$array = [1, 2, 3];
list($a, $b, $c) = $array;
[$a, $b, $c] = $array;
```

2. list()支持在它内部去指定键名。这意味着它可以将任意类型的数组都赋值给一些变量（与短数组语法类似）

```php
$data = [
    ['id' => 1, 'name' => 'Tom'],
    ['id' => 2, 'name' => 'Fred'],
];

while (list('id' => $id, 'name' => $name) = $data) {
    // logic here with $id and $name
}
eg:
$points = [
    ["x" => 1, "y" => 2],
    ["x" => 2, "y" => 1]
];

list(list("x" => $x1, "y" => $y1), list("x" => $x2, "y" => $y2)) = $points;

$points = [
    "first" => [1, 2],
    "second" => [2, 1]
];

list("first" => list($x1, $y1), "second" => list($x2, $y2)) = $points;
```
### 1.8 支持为负的字符串偏移量

现在所有支持偏移量的字符串操作函数 都支持接受负数作为偏移量，包括通过[]或{}操作字符串下标。在这种情况下，一个负数的偏移量会被理解为一个从字符串结尾开始的偏移量。

```php
var_dump("abcdef"[-2]);
var_dump(strpos("aabbcc", "b", -3));

// 输出
string (1) "e"
int(3)

// 字符串同样也支持
$string = 'bar';
echo "The last character of '$string' is '$string[-1]'.\n";

// 输出
The last character of 'bar' is 'r'.
```

### 1.9 通过 Closure::fromCallable() 将callables转为闭包
Closure新增了一个静态方法，用于将callable快速地 转为一个Closure 对象。

```php
class Test
{
    public function exposeFunction()
    {
        return Closure::fromCallable([$this, 'privateFunction']);
    }

    private function privateFunction($param)
    {
        var_dump($param);
    }
}

$privFunc = (new Test)->exposeFunction();
$privFunc('some value'); // string(10) "some value"
```
### 1.10 异步信号处理

一个新的名为 pcntl_async_signals() 的方法现在被引入， 用于启用无需 ticks （这会带来很多额外的开销）的异步信号处理。

```php
pcntl_async_signals(true); // turn on async signals

pcntl_signal(SIGHUP,  function($sig) {
    echo "SIGHUP\n";
});

posix_kill(posix_getpid(), SIGHUP);

// 输出
SIGHUP
```

## 二、新的函数

### 2.1 PHP Core

* sapi_windows_cp_get()
* sapi_windows_cp_set()
* sapi_windows_cp_conv()
* sapi_windows_cp_is_utf8()

### 2.2 Closure

* Closure::fromCallable()

### 2.3 CURL

* curl_multi_errno()
* curl_share_errno()
* curl_share_strerror()

### 2.4 Session

* session_create_id() 调查
* session_gc()

### 2.5 SPL

* is_iterable()

### 2.6 PCNTL

* pcntl_async_signals()
* pcntl_signal_get_handler()


## 三、新增的全局常量

### 3.1 PHP 核心中预定义的常量

* PHP_FD_SETSIZE

### 3.2 CURL

* CURLMOPT_PUSHFUNCTION
* CURL_PUSH_OK
* CURL_PUSH_DENY

### 3.3 Data Filtering

* FILTER_FLAG_EMAIL_UNICODE

### 3.4 Image Processing and GD

* IMAGETYPE_WEBP

### 3.5 JSON

* JSON_UNESCAPED_LINE_TERMINATORS
* [ 让Json更懂中文(JSON_UNESCAPED_UNICODE) ](http://www.laruence.com/2011/10/10/2239.html)

### 3.6 LDAP

* LDAP_OPT_X_SASL_NOCANON
* LDAP_OPT_X_SASL_USERNAME
* LDAP_OPT_X_TLS_CACERTDIR
* LDAP_OPT_X_TLS_CACERTFILE
* LDAP_OPT_X_TLS_CERTFILE
* LDAP_OPT_X_TLS_CIPHER_SUITE
* LDAP_OPT_X_TLS_KEYFILE
* LDAP_OPT_X_TLS_RANDOM_FILE
* LDAP_OPT_X_TLS_CRLCHECK
* LDAP_OPT_X_TLS_CRL_NONE
* LDAP_OPT_X_TLS_CRL_PEER
* LDAP_OPT_X_TLS_CRL_ALL
* LDAP_OPT_X_TLS_DHFILE
* LDAP_OPT_X_TLS_CRLFILE
* LDAP_OPT_X_TLS_PROTOCOL_MIN
* LDAP_OPT_X_TLS_PROTOCOL_SSL2
* LDAP_OPT_X_TLS_PROTOCOL_SSL3
* LDAP_OPT_X_TLS_PROTOCOL_TLS1_0
* LDAP_OPT_X_TLS_PROTOCOL_TLS1_1
* LDAP_OPT_X_TLS_PROTOCOL_TLS1_2
* LDAP_OPT_X_TLS_PACKAGE
* LDAP_OPT_X_KEEPALIVE_IDLE
* LDAP_OPT_X_KEEPALIVE_PROBES
* LDAP_OPT_X_KEEPALIVE_INTERVAL

### 3.7 SPL

* MT_RAND_PHP

## 四、不向后兼容的变更

### 4.1 当传递参数过少时将抛出错误

在过去如果我们调用一个用户定义的函数时，提供的参数不足，那么将会产生一个警告(warning)。 现在，这个警告被提升为一个错误异常(Error exception)。这个变更仅对用户定义的函数生效， 并不包含内置函数。例如：

```php
function test($param){}
test();
```

### 4.2 禁止动态调用函数


* assert() - with a string as the first argument 
* compact() 
* extract() 
* func_get_args() 
* func_get_arg() 
* func_num_args() 
* get_defined_vars() 
* mb_parse_str() - with one arg 
* parse_str() - with one arg

```php
echo call_user_func('pow', 3, 2);  // ok
// -------------------------------
(function () {
    'func_num_args'();
})();

// 输出
Warning: Cannot call func_num_args() dynamically in %s on line %d
```

### 4.3 Invalid class, interface, and trait names(无效的类，接口，trait名称命名)

The following names cannot be used to name classes, interfaces, or traits:
以下名称不能用于**类，接口或trait**名称命名： 

* void 
* iterable


[Trait](http://php.net/manual/zh/language.oop5.traits.php#language.oop5.traits)
Traits提供了一种灵活的代码重用机制，即不像interface一样只能定义方法但不能实现，又不能像class一样只能单继承。

### 4.4 Numerical string conversions now respect scientific notation

Integer operations and conversions on numerical strings now respect scientific notation. This also includes the (int) cast operation, and the following functions: intval() (where the base is 10), settype(), decbin(), decoct(), and dechex().

### 4.5 rand() aliased to mt_rand() and srand() aliased to mt_srand()

rand() and srand() have now been made aliases to mt_rand() and mt_srand(), respectively. This means that the output for the following functions have changes: rand(), shuffle(), str_shuffle(), and array_rand().

### 4.6 error_log changes with syslog value

If the error_log ini setting is set to syslog, the PHP error levels are mapped to the syslog error levels. This brings finer differentiation in the error logs in contrary to the previous approach where all the errors are logged with the notice level only.

### 4.7 在不完整的对象上不再调用析构方法

析构方法在一个不完整的对象（例如在构造方法中抛出一个异常）上将不再会被调用。

### 4.8 call_user_func()不再支持对传址的函数的调用

call_user_func() 现在在调用一个以引用作为参数的函数时将始终失败。

### 4.9 字符串不再支持空索引操作符

对字符串使用一个空索引操作符（例如`$str[] = $x`）将会抛出一个致命错误， 而不是静默地将其转为一个数组。

### 4.10 ini配置项移除

下列ini配置项已经被移除：

* session.entropy_file 
* session.entropy_length
* session.hash_function
* session.hash_bits_per_character

###  4.11 Array ordering when elements are automatically created during by reference assignments has changed

The order of the elements in an array has changed when those elements have been automatically created by referencing them in a by reference assignment. For example:

```php
$array = [];
$array["a"] =& $array["b"];
$array["b"] = 1;
var_dump($array);

// php 7.0
array(2) {
  ["a"]=>
  &int(1)
  ["b"]=>
  &int(1)
}

// php 7.1
array(2) {
  ["b"]=>
  &int(1)
  ["a"]=>
  &int(1)
}
```

### 4.12 Sort order of equal elements
The internal sorting algorithm has been improved, what may result in different sort order of elements, which compare as equal, than before.

> Don't rely on the order of elements which compare as equal; it might change anytime.

### 4.13 Error message for E_RECOVERABLE errors

The error message for E_RECOVERABLE errors has been changed from "Catchable fatal error" to "Recoverable fatal error".

### 4.14 $options parameter of unserialize() 

The allowed_classes element of the $options parameter of unserialize() is now strictly typed, i.e. if anything other than an array or a boolean is given, unserialize() returns FALSE and issues an E_WARNING.

### 4.15 DateTime constructor incorporates microseconds

DateTime and DateTimeImmutable now properly incorporate microseconds when constructed from the current time, either explicitly or with a relative string (e.g. "first day of next month"). This means that naive comparisons of two newly created instances will now more likely return FALSE instead of TRUE:

```php
new DateTime() == new DateTime();
```

###  4.16 Fatal errors to Error exceptions conversions

In the Date extension, invalid serialization data for DateTime or DatePeriod classes, or timezone initialization failure from serialized data, will now throw an Error exception from the __wakeup() or __set_state() methods, instead of resulting in a fatal error.

In the DBA extension, data modification functions (such as dba_insert()) will now throw an Error exception instead of triggering a catchable fatal error if the key does not contain exactly two elements.

In the DOM extension, invalid schema or RelaxNG validation contexts will now throw an Error exception instead of resulting in a fatal error. Similarly, attempting to register a node class that does not extend the appropriate base class, or attempting to read an invalid property or write to a readonly property, will also now throw an Error exception.

In the IMAP extension, email addresses longer than 16385 bytes will throw an Error exception instead of resulting in a fatal error.

In the Intl extension, failing to call the parent constructor in a class extending Collator before invoking the parent methods will now throw an Error instead of resulting in a recoverable fatal error. Also, cloning a Transliterator object will now throw an Error exception on failure to clone the internal transliterator instead of resulting in a fatal error.

In the LDAP extension, providing an unknown modification type to ldap_batch_modify() will now throw an Error exception instead of resulting in a fatal error.

In the mbstring extension, the mb_ereg() and mb_eregi() functions will now throw a ParseError exception if an invalid PHP expression is provided and the 'e' option is used.

In the Mcrypt extension, the mcrypt_encrypt() and mcrypt_decrypt() will now throw an Error exception instead of resulting in a fatal error if mcrypt cannot be initialized.

In the mysqli extension, attempting to read an invalid property or write to a readonly property will now throw an Error exception instead of resulting in a fatal error.

In the Reflection extension, failing to retrieve a reflection object or retrieve an object property will now throw an Error exception instead of resulting in a fatal error.

In the Session extension, custom session handlers that do not return strings for session IDs will now throw an Error exception instead of resulting in a fatal error when a function is called that must generate a session ID.

In the SimpleXML extension, creating an unnamed or duplicate attribute will now throw an Error exception instead of resulting in a fatal error.

In the SPL extension, attempting to clone an SplDirectory object will now throw an Error exception instead of resulting in a fatal error. Similarly, calling ArrayIterator::append() when iterating over an object will also now throw an Error exception.

In the standard extension, the assert() function, when provided with a string argument as its first parameter, will now throw a ParseError exception instead of resulting in a catchable fatal error if the PHP code is invalid. Similarly, calling forward_static_call() outside of a class scope will now throw an Error exception.

In the Tidy extension, creating a tidyNode manually will now throw an Error exception instead of resulting in a fatal error.

In the WDDX extension, a circular reference when serializing will now throw an Error exception instead of resulting in a fatal error.

In the XML-RPC extension, a circular reference when serializing will now throw an instance of Error exception instead of resulting in a fatal error.

In the Zip extension, the ZipArchive::addGlob() method will now throw an Error exception instead of resulting in a fatal error if glob support is not available.


###  4.17 Lexically bound variables cannot reuse names

Variables bound to a closure via the use construct cannot use the same name as any superglobals, $this, or any parameter. For example, all of these function definition will result in a fatal error:

```php
$f = function () use ($_SERVER) {};
$f = function () use ($this) {};
$f = function ($param) use ($param) {};
```

### 4.18 JSON encoding and decoding

The serialize_precision ini setting now controls the serialization precision when encoding doubles.

Decoding an empty key now results in an empty property name, rather than `_empty_`as a property name.

```php
var_dump(json_decode(json_encode(['' => 1])));

// 输出
object(stdClass)#1 (1) {
  [""]=>
  int(1)
}
```

When supplying the JSON_UNESCAPED_UNICODE flag to json_encode(), the sequences U+2028 and U+2029 are now escaped.

### 4.19 Changes to mb_ereg() and mb_eregi() parameter semantics

The third paramter to the mb_ereg() and mb_eregi() functions (regs) will now be set to an empty array if nothing was matched. Formely, the parameter would not have been modified.


## 五、PHP 7.1.x 中废弃的特性

###  5.1 ext/mcrypt

mcrypt 扩展已经过时了大约10年，并且用起来很复杂。因此它被废弃并且被 OpenSSL 所取代。 从PHP 7.2起它将被从核心代码中移除并且移到PECL中。

### 5.2 mb_ereg_replace()和mb_eregi_replace()的Eval选项

对于mb_ereg_replace()和mb_eregi_replace()的 e模式修饰符现在已被废弃。

## 六、Changed functions

### 6.1 PHP Core

* getopt() has an optional third parameter that exposes the index of the next element in the argument vector list to be processed. This is done via a by-ref parameter.
* getenv() no longer requires its parameter. If the parameter is omitted, then the current environment variables will be returned as an associative array.
* get_headers() now has an additional parameter to enable for the passing of custom stream contexts.
* long2ip() now also accepts an integer as a parameter.
* output_reset_rewrite_vars() no longer resets session URL rewrite variables.
* parse_url() is now more restrictive and supports RFC3986.
* unpack() now accepts an optional third parameter to specify the offset to begin unpacking from.

### 6.2 File System

* file_get_contents() now accepts a negative seek offset if the stream is seekable.
* tempnam() now emits a notice when falling back to the system's temp directory.

### 6.3 JSON

* json_encode() now accepts a new option, JSON_UNESCAPED_LINE_TERMINATORS, to disable the escaping of U+2028 and U+2029 characters when JSON_UNESCAPED_UNICODE is supplied.

### 6.4 Multibyte String

* mb_ereg() now rejects illegal byte sequences.
* mb_ereg_replace() now rejects illegal byte sequences.

## 七、Other changes

略

## 八、Windows支持

略

## 九、补充

1. Traits

    Traits提供了一种灵活的代码重用机制，即不像interface一样只能定义方法但不能实现，又不能像class一样只能单继承。
    不能通过自身实例化，需要在类中使用use引入使用。
    
    1. 特性
    
        1. trait是为了给类似PHP的单继承语言而准备的一种代码复用机制。trait不能被实例化。trait用`use + traitname`关键词调用。
        2. 从基类继承的成员会被trait插入的成员所覆盖。优先顺序是来自当前类的成员覆盖了trait的方法，而trait则覆盖了被继承的方法。
        3. 通过逗号分隔，在use声明列出多个trait,都可以插入到一个类中。
        4. 如果trait定义了一个属性，那类将不能定义同样名称的属性，否则会产生一个错误。如果该属性在类中的定义与在 trait 中的定义兼容（同样的可见性和初始值）则错误的级别是 `E_STRICT`，否则是一个致命错误。
        5. 如果一个trait包含一个静态变量，每个使用这个trait的类都包含 一个独立的静态变量。
    
    2. 官方实例：
    
        ```php
        Example using parent class:
        <?php
        class TestClass {
            public static $_bar;
        }
        class Foo1 extends TestClass { }
        class Foo2 extends TestClass { }
        Foo1::$_bar = 'Hello';
        Foo2::$_bar = 'World';
        echo Foo1::$_bar . ' ' . Foo2::$_bar; // Prints: World World
        ?>
        
        Example using trait:
        <?php
        trait TestTrait {
             public static $_bar;
        }
        class Foo1 {
             use TestTrait;
        }
        class Foo2 {
             use TestTrait;
        }
        Foo1::$_bar = 'Hello';
        Foo2::$_bar = 'World';
        echo Foo1::$_bar . ' ' . Foo2::$_bar; // Prints: Hello World
        ?>
        ```

## 十、PHP 7.1.5

php 7.0.19 和 7.1.5 正式发布了。

**PHP 7.1.5**

1. Core:
  * Fixed bug #74408 (EndLess loop bypassing execution time limit). (Laruence)
  * Fixed bug #74353 (Segfault when killing within bash script trap code).
    (Laruence)
  * Fixed bug #74340 (Magic function __get has different behavior in php 7.1.x).
    (Nikita)
  * Fixed bug #74188 (Null coalescing operator fails for undeclared static
    class properties). (tpunt)
  * Fixed bug #74444 (multiple catch freezes in some cases). (David Matějka)
  * Fixed bug #74410 (stream_select() is broken on Windows Nanoserver).
    (Matt Ficken)
  * Fixed bug #74337 (php-cgi.exe crash on facebook callback).
    (Anton Serbulov)

2. Date:
  * Fixed bug #74404 (Wrong reflection on DateTimeZone::getTransitions).
    (krakjoe)
  * Fixed bug #74080 (add constant for RFC7231 format datetime). (duncan3dc)

3. DOM:
  * Fixed bug #74416 (Wrong reflection on DOMNode::cloneNode).
    (Remi, Fabien Villepinte)

4. Fileinfo:
  * Fixed bug #74379 (syntax error compile error in libmagic/apprentice.c).
    (Laruence)

5. GD:
  * Fixed bug #74343 (compile fails on solaris 11 with system gd2 library).
    (krakjoe)

6. mysqlnd:
  * Fixed bug #74376 (Invalid free of persistent results on error/connection
    loss). (Yussuf Khalil)

7. Intl:
  * Fixed bug #65683 (Intl does not support DateTimeImmutable). (Ben Scholzen)
  * Fixed bug #74298 (IntlDateFormatter->format() doesn't return
    microseconds/fractions). (Andrew Nester)
  * Fixed bug #74433 (wrong reflection for Normalizer methods). (villfa)
  * Fixed bug #74439 (wrong reflection for Locale methods). (villfa)

8. Opcache:
  * Fixed bug #74456 (Segmentation error while running a script in CLI mode).
    (Laruence)
  * Fixed bug #74431 (foreach infinite loop). (Nikita)
  * Fixed bug #74442 (Opcached version produces a nested array). (Nikita)

9. OpenSSL:
  * Fixed bug #73833 (null character not allowed in openssl_pkey_get_private).
    (Jakub Zelenka)
  * Fixed bug #73711 (Segfault in openssl_pkey_new when generating DSA or DH
    key). (Jakub Zelenka)
  * Fixed bug #74341 (openssl_x509_parse fails to parse ASN.1 UTCTime without
    seconds). (Moritz Fain)

10. phar:
  * Fixed bug #74383 (phar method parameters reflection correction). 
    (mhagstrand)

11. Readline:
  * Fixed bug #74489 (readline() immediately returns false in interactive
    console mode). (Anatol)

12. Standard:
  * Fixed bug #72071 (setcookie allows max-age to be negative). (Craig Duncan)
  * Fixed bug #74361 (Compaction in array_rand() violates COW). (Nikita)

13. Streams:
  * Fixed bug #74429 (Remote socket URI with unique persistence identifier
    broken). (Sara)

## 十一、One more thing

## 参考资料

* [从PHP 7.0.x 移植到 PHP 7.1.x ](http://php.net/manual/zh/migration71.php)
* [PHP 7.1 新特性一览](http://www.techug.com/post/features-of-php71.html)
* [PHP 7.1 中有哪些重大的更新？](http://www.oschina.net/news/79819/whats-new-and-exciting-in-php-7-1)
* [关于Trait](http://www.jianshu.com/p/d51056367890)
* [TP5中的trait机制](http://www.kancloud.cn/zmwtp/tp5/124931)

