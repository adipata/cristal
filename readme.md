## Overview

The idea is to get some random seed and translate it into numbers in a specific interval. The input can be binary (1s and 0s) or HEX.

## Input format

The software is built as a PHP page and the data is provided as URL query parameters.

```
/?format=bin&data=110000001001000010011100010110011001111000
```

```
/?format=hex&data=0b9572f59b979482bb1fb28af82795bbc09013454c78
```

### HEX translation

If data is provided as HEX, it will be translated to a binary representation.

For translation, each HEX byte is taken individually and converted to it's binary representation. The representation is absolute, it does not require a certain number of bits. So **9** would be `1001` , and **3** would be `11`.

The following HEX `03 0b 95` would be translated to `11 1011 101110010101`.

## How it works

For the following input, we plan to get 5 numbers between 1 and 50:

```
111100001110010111101011001101110010111100101001000001010111011111111011001010001010111110001001111001010110111011110000001001000010011100010110011001111000
```

First thing is to determine the number of bits necessary to represent the maximum, so for 50 which would be `110010` in binary, we need 6 bits.

To get the first number of the 5 required, we are doing the following:

1. Get the first 6 bits from the input data: `111100`.
2. The resulted number is **60** which is bigger than the maximum.
3. We reduce the number of bits from 6 to 5 to get a smaller number: `11100`. 
4. We translate the 5 bits to number **30** which is ok and we can save it.
5. Skip the 5 used bits.
6. Get next 6 bits: `000111`.
7. We translate the 6 bits to number **7** which is ok and we can save it.
8. Skip the 6 used bits.
9. Get next 6 bits: `001011`.
10. We translate the 6 bits to number **11** which is ok and we can save it.
11. ... we continue processing the bit array until we get all the necessary numbers.

```
11110 000111 001011 1101011001101110010111100101001000001010111011111111011001010001010111110001001111001010110111011110000001001000010011100010110011001111000
```

And we continue like this until we get all our numbers.

If we get to the end of the data, we continue with the beginning. So we look at the bits like they would be on a circle.

> [!IMPORTANT]
> 
> Usually the maximum number that can be composed using all the necessary bits, will be greater than the maximum accepted.
> For example 50 is represented on 6 bits, `110010`, but using 6 bits we can get a maximum of 63 `111111` which is possible when using random data.
> To prevent getting numbers bigger than we need, without wasting any bits, we are reducing the number of used bits until we get a number that fits in the required interval. 









> [!NOTE]
>
> If Firefox denies access to a port, that port can be opened using *about:config* and setting `network.security.ports.banned.override` as String, with ports separated by commas.





