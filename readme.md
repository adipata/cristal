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
111100000011111110110000001111111011000000111111101100000011111110
```

First thing is to determine the number of bits necessary to represent the maximum, so for 50 which would be `110010` in binary, we need 6 bits.

To get the first number of the 5 required, we are doing the following:

1. Get the first 6 bits from the input data: `111100`.
2. The resulted number is **60** which is bigger than the maximum.
3. We skip one bit and we get the following 6 bits: `111000`.
4. The resulted number is **56** which is still too big.
5. We skip another bit and we take the following 6 bits: `110000`.
6. We get number **48** which is ok and we can save it.

When we manage to get a good number, we jump over the number bits, in this case 6 of them, and then we try to get the next number.

In our case, we skipped over two bits so we got to a correct number, then we skip over this number an get the following 6 bits which are `001111` and translate to **15** which is also correct, so it is our second number.

```
11 110000 001111 1110110000001111111011000000111111101100000011111110
```

And we continue like this until we get all our numbers.

If we get to the end of the data, we continue with the beginning. So we look at the bits like they would be on a circle.








> [!NOTE]
>
> If Firefox denies access to a port, that port can be opened using *about:config* and setting `network.security.ports.banned.override` as String, with ports separated by commas.





