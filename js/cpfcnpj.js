      document.getElementById('cpfcnpj').addEventListener('input', function(event) {
          chama_mascara(event.target);
      });

      function chama_mascara(o) {
        if (o.value.length > 14)
          mascara(o, cnpj);
        else
          mascara(o, cpf);
      }

      function mascara(o, f) {
        v_obj = o;
        v_fun = f;
        setTimeout("execmascara()", 1);
      }

      function execmascara() {
        v_obj.value = v_fun(v_obj.value);
      }

      function cpf(v) {
        v = v.replace( /\D/g , ""); //Remove tudo o que nÃ£o Ã© dÃ­gito
        v = v.replace( /(\d{3})(\d)/ , "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
        v = v.replace( /(\d{3})(\d)/ , "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
        //de novo (para o segundo bloco de nÃºmeros)
        v = v.replace( /(\d{3})(\d{1,2})$/ , "$1-$2"); //Coloca um hÃ­fen entre o terceiro e o quarto dÃ­gitos
        return v;
      }

      function cnpj(v) {
        v = v.replace( /\D/g , ""); //Remove tudo o que nÃ£o Ã© dÃ­gito
        v = v.replace( /^(\d{2})(\d)/ , "$1.$2"); //Coloca ponto entre o segundo e o terceiro dÃ­gitos
        v = v.replace( /^(\d{2})\.(\d{3})(\d)/ , "$1.$2.$3"); //Coloca ponto entre o quinto e o sexto dÃ­gitos
        v = v.replace( /\.(\d{3})(\d)/ , ".$1/$2"); //Coloca uma barra entre o oitavo e o nono dÃ­gitos
        v = v.replace( /(\d{4})(\d)/ , "$1-$2"); //Coloca um hÃ­fen depois do bloco de quatro dÃ­gitos
        return v;
      }

      document.getElementById('cpfcnpj').addEventListener('paste', function(event) {
            // Lida com a colagem
          var pastedValue = (event.clipboardData || window.clipboardData).getData('text');
          this.value = formatarCPFCNPJ(pastedValue);
      });


    //valida o CPF digitado
    function ValidarCPFCNPJ(Obj){
	var ob = Obj.value.replace(/\D/g, '');
        //if (Obj.value.length == 14){
        if (ob.length == 14){

            'use strict';
            var i, cnpj = Obj.value.replace(/\D/g, ''), pattern = /^(\d{1})\1{13}$/, soma, multiplicador, digitoUm, digitoDois;
            if (cnpj.length !== 14) {
                show_alert(19, 'form-msgModal');
                return false;  
            }
            if (pattern.test(cnpj)) {
                show_alert(19, 'form-msgModal');
                return false;  
            }
            soma = 0;
            for (i = 0; i < 12; i += 1) {
                /** verifica qual Ã© o multiplicador. Caso o valor do caracter seja entre 0-3, diminui o valor do caracter por 5
                * caso for entre 4-11, diminui por 13 **/
                multiplicador = (i <= 3 ? 5 : 13) - i;

                soma += parseInt(cnpj.charAt(i), 10) * multiplicador;
            }
            soma = soma % 11;
            if (soma === 0  || soma === 1) {
                digitoUm = 0;
            } else {
                digitoUm = 11 - soma;
            }
            if (parseInt(digitoUm, 10) === parseInt(cnpj.charAt(12), 10)) {
                soma = 0;

                for (i = 0; i < 13; i += 1) {
                    /** verifica qual Ã© o multiplicador. Caso o valor do caracter seja entre 0-4, diminui o valor do caracter por 6
                     * caso for entre 4-12, diminui por 14 **/
                    multiplicador = (i <= 4 ? 6 : 14) - i;
                    soma += parseInt(cnpj.charAt(i), 10) * multiplicador;
                }
                soma = soma % 11;
                if (soma === 0 || soma === 1) {
                    digitoDois = 0;
                } else {
                    digitoDois = 11 - soma;
                }
                if (digitoDois === parseInt(cnpj.charAt(13))) {
                    remove_alert();
                    return true;
                }
            }
            show_alert(19, 'form-msgModal');
            return false;  

        }
        else{

            'use strict';
            var i, cpf = Obj.value.replace(/\D/g, ''), pattern = /^(\d{1})\1{10}$/, sum, mod, digit;

            if (cpf.length !== 11) {
                show_alert(18, 'form-msgModal');
                return false;  
            }
            if (pattern.test(cpf)) {
                show_alert(18, 'form-msgModal');
                return false; 
            }
            sum = 0;
            for (i = 0; i < 9; i += 1) {
                sum += parseInt(cpf.charAt(i), 10) * (10 - i);
            }
            mod = sum % 11;
            digit = (mod > 1) ? (11 - mod) : 0;
            if (parseInt(cpf.charAt(9), 10) !== digit) {
                show_alert(18, 'form-msgModal');
                return false; 
            }
            sum = 0;
            for (i = 0; i < 10; i += 1) {
                sum += parseInt(cpf.charAt(i), 10) * (11 - i);
            }
            mod = sum % 11;
            digit = (mod > 1) ? (11 - mod) : 0;
            if (parseInt(cpf.charAt(10), 10) !== digit) {
                show_alert(18, 'form-msgModal');
                return false; 
            }
            remove_alert();
            return true;
        }
    }
