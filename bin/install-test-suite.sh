#!/usr/bin/env bash

if [ $# -lt 1 ]; then
	echo "usage: $0 <wp-test-path> [wp-version=latest]"
	exit 1
fi

WP_TEST_PATH=$(echo $1 | sed -e "s/\/$//")
WP_VERSION=${2-latest}

WP_TESTS_DIR=$WP_TEST_PATH
WP_CORE_DIR=$WP_TEST_PATH/src

download() {
    if [ `which wget` ]; then
        wget -nv -O "$2" "$1"
    elif [ `which curl` ]; then
        curl -s "$1" > "$2";
    fi
}

if [[ $WP_VERSION =~ [0-9]+\.[0-9]+(\.[0-9]+)? ]]; then
	WP_TESTS_TAG="tags/$WP_VERSION"
elif [[ $WP_VERSION == 'nightly' || $WP_VERSION == 'trunk' ]]; then
	WP_TESTS_TAG="trunk"
else
	# http serves a single offer, whereas https serves multiple. we only want one
	download http://api.wordpress.org/core/version-check/1.7/ /tmp/wp-latest.json
	grep '[0-9]+\.[0-9]+(\.[0-9]+)?' /tmp/wp-latest.json
	LATEST_VERSION=$(grep -o '"version":"[^"]*' /tmp/wp-latest.json | sed 's/"version":"//')
	if [[ -z "$LATEST_VERSION" ]]; then
		echo "Latest WordPress version could not be found"
		exit 1
	fi
	WP_TESTS_TAG="tags/$LATEST_VERSION"
fi

set -ex

install_wp() {

	if [ -d $WP_CORE_DIR ]; then
		return;
	fi

	mkdir -p $WP_CORE_DIR

	if [[ $WP_VERSION == 'nightly' || $WP_VERSION == 'trunk' ]]; then
		mkdir -p /tmp/wordpress-nightly
		download https://wordpress.org/nightly-builds/wordpress-latest.zip  /tmp/wordpress-nightly/wordpress-nightly.zip
		unzip -q /tmp/wordpress-nightly/wordpress-nightly.zip -d /tmp/wordpress-nightly/
		mv /tmp/wordpress-nightly/wordpress/* $WP_CORE_DIR
	else
		if [ $WP_VERSION == 'latest' ]; then
			local ARCHIVE_NAME='latest'
		else
			local ARCHIVE_NAME="wordpress-$WP_VERSION"
		fi
		download https://wordpress.org/${ARCHIVE_NAME}.tar.gz  /tmp/wordpress.tar.gz
		tar --strip-components=1 -zxmf /tmp/wordpress.tar.gz -C $WP_CORE_DIR
	fi
}

install_test_suite() {
	# portable in-place argument for both GNU sed and Mac OSX sed
	if [[ $(uname -s) == 'Darwin' ]]; then
		local ioption='-i .bak'
	else
		local ioption='-i'
	fi

	# set up testing suite (includes) if it doesn't yet exist
	if [ ! -d $WP_TESTS_DIR/includes ]; then
		mkdir -p $WP_TESTS_DIR/includes
		svn co --quiet https://develop.svn.wordpress.org/${WP_TESTS_TAG}/tests/phpunit/includes/ $WP_TESTS_DIR/includes
        # silence test meta introductory outputs
        sed $ioption "s/echo /\/\/ echo /g" "$WP_TESTS_DIR"/includes/install.php
        sed $ioption "s/echo 'Running/\/\/ echo 'Running/g" "$WP_TESTS_DIR"/includes/bootstrap.php
        sed $ioption "s/echo sprintf( 'Not running/\/\/ echo sprintf( 'Not running/" "$WP_TESTS_DIR"/includes/bootstrap.php
	fi

    # set up testing suite (data) if it doesn't yet exist
    if [ ! -d $WP_TESTS_DIR/data ]; then
        mkdir -p $WP_TESTS_DIR/data
        svn co --quiet https://develop.svn.wordpress.org/${WP_TESTS_TAG}/tests/phpunit/data/ $WP_TESTS_DIR/data
    fi

	if [ ! -f "$WP_TESTS_DIR"/wp-tests-config.php ]; then
		download https://develop.svn.wordpress.org/${WP_TESTS_TAG}/wp-tests-config-sample.php "$WP_TESTS_DIR"/wp-tests-config.php
	fi

}

install_db() {
    # portable in-place argument for both GNU sed and Mac OSX sed
    if [[ $(uname -s) == 'Darwin' ]]; then
        local ioption='-i .bak'
    else
        local ioption='-i'
    fi

    if [ -d $WP_CORE_DIR/wp-content/plugins/sqlite-integration ]; then
        return;
    fi

    svn co --quiet https://plugins.svn.wordpress.org/sqlite-integration/tags/1.8.1/ $WP_CORE_DIR/wp-content/plugins/sqlite-integration

    sed $ioption "s/if (stripos(\$opt->compile_option, /\/\/ if (stripos(\$opt->compile_option, /g" "$WP_CORE_DIR"/wp-content/plugins/sqlite-integration/query.class.php
    sed $ioption "s/echo /\/\/ echo /g" "$WP_CORE_DIR"/wp-content/plugins/sqlite-integration/install.php
    sed $ioption "s/echo /\/\/ echo /g" "$WP_CORE_DIR"/wp-content/plugins/sqlite-integration/install.php
    sed $ioption "s/echo /\/\/ echo /g" "$WP_CORE_DIR"/wp-content/plugins/sqlite-integration/install.php

    cp $WP_CORE_DIR/wp-content/plugins/sqlite-integration/db.php $WP_CORE_DIR/wp-content/db.php
    mkdir -p $WP_CORE_DIR/wp-content/database
    touch $WP_CORE_DIR/wp-content/database/.ht.sqlite
}

echo "Setting up wordpress"
install_wp
echo "Setting up test suite"
install_test_suite
echo "Setting up database"
install_db

# (
#     install_wp
#     install_test_suite
#     install_db
# )  > /dev/null 2>&1
