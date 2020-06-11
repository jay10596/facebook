<template>
    <div class="w-2/3 p-4 bg-white shadow rounded">
        <div class="flex justify-between items-center">
            <img class="w-8 h-8 object-cover rounded-full" src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxITEhUSExIWFRUXFxcXFxUWFRUVFxcXFxUXGBUXFxUYHSggGBolGxUXITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGxAQGi0lHx0rLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS8tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAOEA4QMBIgACEQEDEQH/xAAcAAABBQEBAQAAAAAAAAAAAAADAAIEBQYBBwj/xABGEAABAwEGAwQGBgcIAQUAAAABAAIRAwQFEiExQVFhgQZxkaETIrHB0fAyQnKCsuEUIyRSYpLxFRYzorPC0vKDBzRjw+P/xAAaAQADAQEBAQAAAAAAAAAAAAABAgMABAUG/8QAJREAAgICAgEEAwEBAAAAAAAAAAECEQMhEjFBBCJRYRMycSMF/9oADAMBAAIRAxEAPwCrxLoel6I8E0tXhnu0cqiQotKx5ypcIlFuYW5NB4pl9djYaFYNcoVlEAKRjAXnyts6klRJD1FvCp6pRQodvBwlNjXuRpVxZlahzK4Vx+pXabCTABJ4DMle4keU2BqBQ6jc1qLBchJ/WGP4Rmep0CtGXdTZ/hsptP7zpc7oD+SaKJykjGWe6qzxIpujich5qR/YNcCS0d2IE+S1QpEukl1Y7AZMHedPNPrmpMcNhhgd+WnVVok5GEq0HNMEQgOavQxQe9sOp0zyJLp6aKmt110ZwuaaTp1Ekd0LUZSMk9qQCsrzu11M5HE394CPEbKBCwRi44J4SesYbCRTk0qTY6BkLkp5QylsNHCFwhPSAlUTEaAwi2eyOqGGiVaXbcbn5uyCtq1qpWdsNAJTk2yn/u9U4pKR/eF/BJYFmjcBwUSvTzXaNvDs1ypUleQrR63aA4FIslMShAqXYBJQm6Q0U7LakAm1rMXbp7QiArkujo4s7SGEQgXi8YCjwq68ycJhHHuaBNNRZmqVFz34WiSStLZqNOzsnV0es46dwHBRLkApgvIGN2k7N3PUqsv61+kOGfVnXYnc817f0eRJlmL3fUMM046A95Rg8neTwmB4DM9VSWV2NpDA7KJ55amE6kC0xhPjl4IsCiW76jsi57WjgCP6oz7U2MIeOca9SMws9arM/WRnnmQD4SiWSzwILm9+Up4CyQa2WoyMzG2Z8j/VPtVrL6ZDBG5xDET1Mx3BI2RmxnvOZ5AK9um6gTJGyq18CpfJnKdoOHCWESQ2DoeY4qDa7BqW58RHhHfwXp1bs2x1LMdxWDvJho1CyIcM41BG5k7fmlpoL+jNgLjlob6sgdSbaGCJyd7Afz3yWfcszJ2cCY5PCRCg2VitA0whFa0nIZq5u24C71qmQ4LJWaTSKix2J9Qw0dVo7JddOiMTyCeaLarwpUBhYASszbre+oZJ6KqVEW3Losbzvwn1aeQ4qiqPJMlccUIuRsFUPldQsSSIDXWCn6qnNpngu3NTBarVtILyp/senCXtRS1aLtgrO7KDo0UoMHBWdlpCFDK9UWhLZEFMp4plWLWhdc0LlorzIAolRbws5wq8ZCi3oRgVMMbmv6LPJ7WY683EjCMue+HYROp96p7Bd7q9YCPVGw2aNucxCsq9acTeJI92Q71oeyNgDQTqTuvoJR+Dxou+y0sF1U6dKMOZzdzlVlazsboAI2WltLDhWZrWdxPvOalKLWjpi7K6rZQ8yeg+IR6V3g7eUDxVnZLI3fMqwpWKctB0TwTM0itu66s5C1122FrWjLMKNYaIblwVtTK6IKjnn9Dg3KFkO290BzBWaPWZrzbv7Patg92Si2ukHsc12hEHuK0uwR6PLKTXGyuZEeoXQc/oukeUrKuC3taiKZew6w4DnDYI9/VYg0iThGZ5KcjRAMUyxXc+qfVGXFXF1dnPrVchwU28L3p0RgpgE8lDjbKc6Qyz3fRs7cTyJ5qovS/S71WZBV1ttr6hlxlRCm5VpC8b2zlR86oZXXBNRRmMKYQjU6ZcYAkrRXX2c+tU04J0Tk0jLxySW/8A0Kz8kk3En+RDrgZLArYU1W9nB+rHcrgBeRN+5nqQ6RxlHNWtGlkoFHVWWOAufIViL0acKKBQqklSwVOhrGiiqrtIMNFzuEdcxkriVWdoWg0XTmInwz9yrg1lj/SeXcH/AAw1lokOA1O556a923Pktv2bHq4d1j3u0AyB6Sea3HZSyD0eMnVfRVbPJ6RZXgcIWdcc1o7UzFkof6HSH0ipZdvR1YnS2RrHSlWtKgouKmzR4HeVNoWpmzgjBDSd9BKVNSqIQ8QiQjWZ44qyRGTOvBQahyU0id1Gr0YzSSQEzzHtxULaojeeukjmiU7PRs7cTonzQe3Jmrlqwg+z4rNWq0ue6XGVF7D5LG9L8fUyb6rVSVCiuQnBTvY6VICUMozgu0LM55holAJHlWN3XPUqnSBxV9dnZ1rRjqnon3lfjKYwUwJVYxISyeEPo2WjZmyYlUV7doHPybkFWW23OqGXGVBKa/gTh5Yf9KdxPiko6S1hpHofZ2oPRjuVx6UcVmezlEmmM1cmzO4rx8j9x6kF7SzsjhOqsS4EaqjsdldxU8USuactlox0TaMcUbEq5lAjdSqYKVsPEkgqpvy/mWY02ml6V1UlrQSABoNwf3lOqVIVD2hDAaVpqDE2jjOH95xDQweJn7qv6V/6I3FPTI9ewDGXABokjBDSJ1IgjIhW133IQzG2ofsjE0f5SFT9l7z/AEj0rRSwtbDmukn1nHMEneGiI2BW2uynFEL6CErR5GWHGbPO7wp25lZzXWmKcl0Mccmz6rZgGYIElRH3xUYP8VpHEy/PmXStF2ksTTWBeThecDtABlibJOkuYG/eCqbZdbA4k2UidcIy8FLim9lEn0is/tiprjaQf/ibnxggLtG/nF2EOAdtEge1XFnsFIU3U2UHAO+lDeGY1KzltuU06mJrTM5AmSTsFVqEdoCUvJc3J22tDQ7FSe8CQXNEgd+yMO0tpcMYc1rT9EHMxzzgCVs+w12Mo2dtKAcjjn6xP0p6krMXj2dazEzOKTzGU/q3Eupk7xBw97Ssug8XYGw9pbSD/iNcPtNnwWjuvtNUccLoBPESPIrMXVcFnDi70pzIOAkYZDS2cgDvxVldvZvDVBZVc4SJaYiPaml1picX5Rnu0ltbUrY6hfSL2hwaWtIjQfWBzjaVRzmtrYLD6W11XYoFKlAcfqgggxxiAe4rGtaoM1VsTk2FNs1ifUMNHVaa7riZSGOoZPNSS2NKSSKG7LgfUzdk1X7vQWVu0+aj3pf4aMNLxWStdpc8yTKdVEl7p/wn3tfr6mQMN4KlcZXSFOu26alY+qMt3HRa7DxUUVhYSYGq0Fz9lnPh1X1W8N+qv7HdNCzNxvInifcqe+e05MspZDjunSrsm5XpFz/YFm/dC4sN+n1P3j4lJG0DhI23Zhn6odytyCs32ctZDAIV822Z5rxcn7HrwTotLK3JEdKHZ64hHxhczastTO0jxRgEIELpcldB2PqU5Ue0WAVGOpkSHbeXtIRMaiWq2upw8bezcKuCSWRCzT4uitsF2GyxRGYFRznEA54mgATpIgBbCwH9SO5YW0Xk19QFtRzgTm07EjORxV7Zb4DaIE7ande/BUmebmlyaYW0UQ9xJ+eihU7E0ZUwWD+Co+mP5WkDyRLTeDWtmdc/FQG301skmAilseDVBLfQqAfTcB9r36qFdd243Y3F7s8nOLnR3FxJVVfV71KwIY7DwXK/bepTAp06IENAkkRMRInVBpN0PaSs9Uuim1rQAUO+rBiIe0lrxlI3afqumQc8xI3PFeY3P2trNeJeHl2oGx71rrk7R1a7nU30HgEfSdhiOMhxVV1ROrdok0rC/Fm1o5+jme+HAeSsBd9U/XazmykGuHiSPJVljvd1KsaFUyDmx3EfELS07WC0rC5E0Z+ncjKXpvRznSeXYiXOc94dJJOpy6QsRdHZ9z4c/IcF6FaL1ptZVJIza0DrI9hWGvTtBlhp5DipzRFy8FlaLZRs7cIieAVffrajqXpCYHBZsvLnSTOa2d+j9k6BaKVMnK7Rgy+UxlIuMNBJ4BWt13FUrGYwt4n3LU0bJZ7I2TE8TqVGMWy8ppFRdHZbR9b+X4qfeV90bOMFMAuGw0Cpb57TPfLWeq3zKzxknNVtLSJU5bYa8ryqVTLie7YKucpFVqGGJbHSS6ArqNgCSAxrrgrMDBKsfTsJWSu98N1VhQfmvMngTd2d8MuqNlRtTAEQWpqzVOopGNcrwoupmgFsanfpjVm/SJ2MrfgRuZoP05qiXjbGlhVI+VHtDjCri9OuSEnl0Vtld+u6mPBTrTbMLYOsZ+ZIjvyVYxsPmd1NvazYC+TpoI4mRn1Ga92K0eVJ7IdvvQksBOWXhvKj3heQ9JybEcJ3Mb8FW2+rnG4/oZ8CozhjMmefPL8/NFIVyLqzXywg4jyHeTy5B3gn1/RuIJIMgkdJHz3KHZrqGRj1Sf6FXlG6W+qSMtAPnwSKmy0Va2wb61NgpvaWjPTeFo7ovIA4i4b5Tw4qFZ7rsziC6mzM/uj3KdU7LWV7TBM8stCrNfYzivDOX3bW1AHNcMbHAt78wR5eYVrTveAzOJYXEcOPvXnT2Oo1y0vloJ8BEezyUyteJfULh9GIAB1GXwS0R5volX1bi4kZwD73FVJcUWrPfPVW109nn1Yc71W+ZUpPYF8ka67pq1c2jJegfoLfRBtSDEZbKPQtNKytDBE7DdRb2tDsOMmG8E8U6JSlYO+r09Cz9W2eewWDtttfUdic4laC+rxa9kDgsuQoyky2OKq2cK61dwLjnIR7HfQqkKO96c8oBKcWzuJJNSWoHIvbtpAtVrZ7OFU3c04VbWdjlwTO6BJawI+EQoYouRfRPUXH7KphMIT8KCyzO3KDabUGbrRg5OkaU1FWw1VwGqqrXa9gispVKp4BSX2AMaeK64Rjje9s5pOU1rSKAklbDtndp9DStLd6VMPjY4BDp8vBZJ5zK9VtTB+jU2uAI9GwEH7ABBXcmcdeDwm2PkwMszOXMRPSUWzH1WnI/IKtu0dxEPcaUlp1aNdct81WnLISIEQ7LVpBJG2iotk3aZeXTagwQ4Eg5x1haOi6m5ktEaxO3E8t157TtBa2Qcx5Yg0D2yp1mvlzWmND+XlmpuG7LRy0qNtY6TA8DXXoVOq26nTDwZDoI1BGkj5jZee0r7IqzPn3D80603rjc4mfoz5j3ynSA8gSvWx4pG5IOh+c1CsRcXBrc3OgADf4BOr1i9jA0eschAnYHrmY6K5uG7BZYq1nS+CAxpzbM6u7oWfRK9mqu242Ux6SqQSOOgUe9u04aMFL+b4KgvK+KlXImG7D51VeVK6HSb7JP6W5z8RJJV1etuc6jB4LP09VobyoH0E8k0emLKtGYklLRcxoLyVHiXUhz3poTJTwmS2K5aB1UEotUoJT0TsSSSSNGNdctlloV5RsKhdnLOSwLTU6EBeJkyOz14RVFfTscJVw1okpXleTaYic1U0bJWtBl0hvBNDG2uU9IE8iWo7YKvbnPOGmJ5qXYuz5PrPMlXFjutlMZDNSiStP1Nax6QqxXueyAywhuQUW32Q4SrhQr2qhtMkmBxKTFOTmqGnXFmTue6HV7Q2ntMuPBg+kfd3kL0m/zDIVf2Ss9JlIva9j3vzc5pBDeDMuG/PuCN2lqS0Dr5L170zhUdo87v8Arw4kcVn3W1jzDwAePRX990ZlZO02Mzkjjk0LkiSLTY5aQ3MHLgSOarLQ1zWhonLXLn/TwVhY3uHqlOFhdUOmSvysjxKQUnc5kq4uq5a9WGhp11OwG0dVorn7Ok5kfPNbm5Lrw5xoPafyQsyiRrh7LU7PQe8jFUwwHHVs64eG2iyV4/TK9VtrIs7+q8pvA+uUJ9Ah+zIwanYE1cL1Ki1hKTcwtffNP9l6BY6i71gtpfB/ZegVIeSM10YPAmOajYkGo5IUBErspqRKdIm2DqISM9BJTUA5CS7KSxj0Ls9aA1gngi3rer8mtGu6ruzlgfUc0/VGyv74s4a5ghcMPTw3Lto6555aXSZDu26J9eoZPNXrHBogBMpsJAQrXaKdIS9wHAbnuC4JKeWVdnWnCCJGNCtNqZTbieYHzoN1lry7VRlTEczme/gszb7zqVDic6Z2JPku7D/y5PeR0vjycmT10VqGyyv7tXV9NDXOZTDZAY2S6Z1dGSqbbftSs0AucY2dqo77U7Q5jWNOoO3fpz2UG1MkYhPf8eXNetHDCH6paOGWSUu2SLJe1Wi/HTeWO5b8iDqFrLH27bVDadoAY4ZB4nCe/wDdWBc7jPeo9QFCeOM+wwySh0ep1qQfmM5UR11TssFdd91rOfUdLf3HZt6Dbot1cna+z1IFSKLt8R9To/brCisLiX/LGXZCtV2QdFMuhjZgjNaK12RrgHCCDuIII71T2qzlpBaJIOyNUE1lgoNAmFb2Juroj3KluyoXgZQr2QGwchGfdufCVmwVRy0uxWUniJ8V5RbvplXdydp3NpuoPOKmMmk6tBmO8ZFU140zinY6HYp82NxRDFJNkNxTCnuCauY6B9DULaXsf2XoFi6Oq2V6u/ZfuhNDyTyeDDuQXor0BxQGGhJy4CuOKoiY1yCUYhNbTWMDSR/QJImPW7psf6Oxs57Kvv68aYeCXCRsMz3QqrtD2wNX1KQDWj6x+kcteAyz+ROJtVpc4zJM9J/4t8ynxekUbvyLk9Q5VXg1949rnkYaQwjjqfHQLM2m2ufLi6Z3JyPeTl4SqwVe7L6xHqjkxqJjjMkg7Tm89w0aF0Y8UMaqKojOcpbkwr3yY48sz3NOve5KRmZ7yTIHefrnlog4tR4gH8b/AHBN9LGc6aOjIfYZueZTikuCco12Osbvdw5JBmhAOcxz4niMt81G9Pt1wk5n+Ko73IdW3F3qtOW7tC+NWt4DksYJWszDJOWskcJ1jbkFCqWEj6J5QePBShaAYzncd3xB28kjtn179T3ocUGyprUo1y57JjQrdx1kbTG2eTW+9RqlladDB05ZDM8hOSXiGzthvGtR/wAKo5nIHLq05HwVxZ+2dYf4jGP5iWnyy8lnjTe3UZcR85JuMckHFPsZSa6PRrt/9RqLYxUKk8nMI8yF2/e3BtNMspU3U2nJxcQSRwEaBedU44jxVxZmgNknJNDFG7BLLKqJlGqWgnjz2E+8lWVG2EZajxB45KkdUJOkcuW3X495U1mcf0juPcPNdHZAnPwO09U+I/JAqUyNdOIzHigCsN+UHbMDUfI7k9loI37wc57x88lzZPTRl1ovDNJdj6RzWsvJ37N0CyrIObeo94+Gy09vd+zdAuTg4NplpSUkmjIPQXIr0FxUyg0hNhdTgnEOEJrJJgCTwCn2K7KlU5CBxWjs1go2ZsuieeqSU0hlCzMf2fW/dSWl/vDS4LiXnP4G4x+TG1Ks/CdeOe7QcydyhTPOc+GLmTs1R31OPKR+Fg9646rrJ4YuZ2aOS9SzhoOTuD9/6o5NG6bpnmBx+s7u5IeMznrw+q0fFcFTnqR6xGbt8ssgiAI47QOIbsObuKEXbg8sWpPJjU2dpyMlx4gJYt9/V6T9VBhAuqZaQ3IxuQcpJ5JocdD3T/EPou6ohZt9sfkmuHsafAwlCcFY6/ejmPpBFbXjfIEdA74H2pmHP7zh4iU0afdb+JExIFXw9hH9ddO5IctNOky4880IyDlr6/xHiiTOgE+RykSPESsYcSddNT1Pqt8kqg10P0syAdB8VweOWXhLfMEdUZrp06febI+CZIDBYYJ9VuU/VGwBG3epQB3z1GZ5xnyyb0cVylUGUb4YyGUt9X4IgfMRlIHmIHgRCdIULTbv8nXXxPieKeau259/szhRmuwty4SB91x9oK5rOfzp7mFNYpJFTh8z/wBx4LgnbThuNdJ1EDTzOiEXb/O597U1xjp7sj5Md4oBJtKtGYOmusjpqD06BXzLy9JSNMj1oy4H3T1WU9Id9eO+unMSDlzHeiMrwe+M504Z8MxyzBhJKKkqYU2iVVQsKmUR6RpP1hrz5p1lu9z9cgvNnHg6Z3RfJWQ6VNzjDRK0N23EB69U9Nk5lWlQblEqqt971KmQyCX3S6DpF5b77p0hhpgSsxXtNSs7cpWaxuec9FoLLZ20xkM1lFR6M5X2Un9kVeC6r70z/wB1JH3AuJ5u6oeo/E74JgqeWQ+1uULH7J6uyC4DHTLqdT8813WctExr9tR+IogJnYnf+HI5DmojHcNsh37lHpnTXXLmYMuKdMVnScvu+10J9QZn7Q8ghTkO4fiRYz+8fDQrGOA5/ePn/RMGn3T5GVwTHOPNp+Cdv1B6OCATm882nxEJkZdHDwXYy5wR1aZTh9L734gsY605zzaehEFd0HMD8DkwDL7v4XI28fxEfztWQB5PlijoQ8J2kxtmPuuDh5OTKZGR+yehBaU5m08p82H3J0AfGw/iA6HG1PJ4c46jG3zlCadz/CT0OB3uT2GOntY7P/KUQBDHSfIkO9jz4JoMCeXsDT7WFLDt93zLPY5vguN+epB/3nwRAF06e4//AJpvu93/AEd4podl4expPsclPl7tfwvWMKI49MtiJ8WtPVNadvnXbx/zpxy7x7vzp+aaeWW3hlPt/lCDCWFx2jDUHCCDw7x1HzKs7VekZNyVHZR67evsy+eSn0rHu5cfqF7kzowvRtrpuSjUphzszxR6lw0BoAjdnaQ9EO5THsEqNDNlay6aQ0C6bCwbKxa0cER1EcFgWVPoG8FxWWAcElqDZ4A459SfDJdHz3lMcPcPeUmu369TouokFb+Q95+eCNSdw006DOfJR44d3U6+SLTf7+WQEJkANTzjub5ulFInqHeeQQaOo7meUlPZmOg8ZkBMgHTx5g+IgpoblHJw6gyE4jhoZ8HZjzBXJ3+y73FYx06g8wejhB80Mac8I8WnPyTy3bk4dQcTU4a8sXk8fFYxwDPq4fztkJNdvyafAwUtugPVhz8kjw5uH8wxBEA8jYfxjwOIIhMzzn/M3EPNqDj3+y7xGErrTHQebHfBEAbFPX2Pb/yC7TfMTvhn7wwu8wguynlI/lcHDyRDuPtAZcRjb5hGzBJJ7/eW/wDJiTs/MeMx+Nvgli36+x4965G2+nUSB/tRAxxM57a9DmfJ7vBIHj19/sf4pgjp7j+VTySH9fafY9YASfnu/wCp8Vzb29Bn7T4rkbfM6e0uSnPTn4uHwWCTLrH61k7uhaSvd5cIGSzt0N/aKI4vaPEwvTBcrjoVy52k0Vx2NuCkWUgFZObkg2SylgwkyiudGSh2OwLSVMpaJNbkntCxhYAuruJJYx84u3+fqhM36tSSXQIEG3eURmh+yPYkknQA1HXw/CUrPoPue0rqSKAEdt938aY3Q9z/AGlJJEw5uv3h/ppo0H2WfiKSSwAjt/8Ay+xcOo+0z8BSSTABj6P3B+Moh3/8n4VxJAI/c9f9NPp7fc/CkkmQB1PQdw/03LrNfnjTSSWQGDdoe7/YiO+t1/8AsXEkQDxr1/3vTTqO4exySSzCT7k/91Zvt0/avaqKSS4vU9ovi6ZHrfSUZ/0kklKIZEtuicEkkWYSSSSxj//Z" alt="">

            <input v-if="! editMode" v-model="postForm.body" type="text" class="flex-auto mx-4 h-8 pl-4 rounded-full bg-gray-200 focus:outline-none focus:shadow-outline" placeholder="Add a post">

            <input v-else v-model="post.body" type="text" class="flex-auto mx-4 h-8 pl-4 rounded-full bg-gray-200 focus:outline-none focus:shadow-outline" placeholder="Add a post">

            <div v-if="! editMode">
                <transition name="fade">
                    <button v-if="postForm.body" @click="postMessage" class="px-2 text-xl">
                        <i class="fas fa-share"></i>
                    </button>
                </transition>

                <button class="w-8 h-8 rounded-full text-xl bg-gray-200">
                    <i class="fas fa-image"></i>
                </button>
            </div>

            <div v-else>
                <transition name="fade">
                    <button v-if="post.body" @click="updateMessage(post), post.body='', editMode = false" class="px-2 text-xl">
                        <i class="fas fa-edit"></i>
                    </button>
                </transition>

                <button @click="commitCancelEdit(post), editMode = false" class="w-8 h-8 rounded-full text-xl bg-gray-200">
                    <i class="far fa-window-close"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from "lodash";

    export default {
        name: "CreatePost",

        data() {
            return {
                editMode: false,
                post: '',
                originalPost: ''
            }
        },

        computed: {
            postForm: {
                get() {
                    return this.$store.getters.postForm;
                },
                //_.debounce (function is to make sure the form is not updated after every character that user types.
                set: _.debounce (function(postForm) {
                    return this.$store.commit('updatePostForm', postForm);
                }, 1000)
            }
        },

        created() {
            EventBus.$on('changingEditMode', (post) => {
                this.editMode = true
                this.post = post
                this.originalBody = post.body
            })
        },

        methods: {
            postMessage() {
                this.$store.dispatch('createPost')
            },

            updateMessage(post) {
                this.$store.dispatch('updatePost', post)
            },

            commitCancelEdit(post) {
                post.body = this.originalBody

                this.$store.commit('cancelEdit', post)
            }
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
