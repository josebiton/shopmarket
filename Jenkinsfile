pipeline {
    agent any

    stages {
        stage('Preparacion') {
            steps {
                git branch: 'main', url: 'https://github.com/josebiton/shopmarket.git'
                echo 'Pulled from github successfully'
            }
        }

      stage('Instalar extensión dom para PHP') {
    steps {
        sh '''
        sudo apt-get update
        sudo apt-get install -y php8.1-xml
        '''
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
                mv composer.phar composer
                exit $RESULT
                '''
            }
        }

        stage('Instalar dependencias') {
            steps {
                sh 'php composer install'
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

        // Stage para ejecutar SonarQube (comentado por ahora)
        // stage('SonarQube') {
        //     steps {
        //         script {
        //             def scannerHome = tool name: 'sonarscanner', type: 'hudson.plugins.sonar.SonarRunnerInstallation'
        //             withSonarQubeEnv('SonarQube') {
        //                 sh "${scannerHome}/bin/sonar-scanner"
        //             }
        //         }
        //     }
        // }
    }
}



