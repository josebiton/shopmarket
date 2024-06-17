pipeline {
    agent any

    stages {
        stage('Preparacion') {
            steps {
                git branch: 'main', url: 'https://github.com/josebiton/prunac.git'
                echo 'Pulled from github successfully'
            }
        }
        
        stage('Instalar Composer') {
            steps {
                sh '''
                EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
                php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                ACTUAL_SIGNATURE="$(php -r "echo hash_file('SHA384', 'composer-setup.php');")"
                if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
                then
                    >&2 echo 'ERROR: Invalid installer signature'
                    rm composer-setup.php
                    exit 1
                fi
                php composer-setup.php --quiet
                RESULT=$?
                rm composer-setup.php
                mv composer.phar /usr/local/bin/composer
                exit $RESULT
                '''
            }
        }

        stage('Instalar dependencias') {
            steps {
                sh 'composer install'
            }
        }

        stage('Verifica version php') {
            steps {
                sh 'php --version'
            }
        }

        stage('Ejecutar php') {
            steps {
                sh 'php index.php'
            }
        }

        // Revisa la calidad de código con SonarQube
        // stage ('Sonarqube') {
        //     steps {
        //         script {
        //             def scannerHome = tool name: 'sonarscanner', type: 'hudson.plugins.sonar.SonarRunnerInstallation';
        //             echo "scannerHome = $scannerHome ...."
        //             withSonarQubeEnv() {
        //                 sh "$scannerHome/bin/sonar-scanner"
        //             }
        //         }
        //     }
        // }
    }
}

